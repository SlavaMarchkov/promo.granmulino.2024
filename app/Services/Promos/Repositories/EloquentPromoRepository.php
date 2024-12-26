<?php

declare(strict_types=1);

// 09.11.2024 at 21:54:41
namespace App\Services\Promos\Repositories;


use App\Enums\Promo\TypeEnum;
use App\Models\Promo;
use App\Models\PromoMark;
use App\Models\PromoProduct;
use App\Models\PromoSeller;
use App\Services\Promos\Filters\Category;
use App\Services\Promos\Filters\Channel;
use App\Services\Promos\Filters\City;
use App\Services\Promos\Filters\Customer;
use App\Services\Promos\Filters\Id;
use App\Services\Promos\Filters\Mark;
use App\Services\Promos\Filters\Product;
use App\Services\Promos\Filters\PromoId;
use App\Services\Promos\Filters\Retailer;
use App\Services\Promos\Filters\User;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EloquentPromoRepository implements PromoRepositoryInterface
{
    /**
     * @throws BindingResolutionException
     */
    public function get(array $params = [])
    : Collection {
        request()->merge($params);
        $promos = app()->make(Pipeline::class)
            ->send(Promo::query())
            ->through([
                User::class,
                Customer::class,
                Retailer::class,
            ])
            ->thenReturn();
        return $promos->get();
    }

    /**
     * @throws BindingResolutionException
     */
    public function find(Promo $promo, array $params = [])
    : ?Promo {
        request()->merge(['id' => $promo->id, ...$params]);
        $promo = app()->make(Pipeline::class)
            ->send(Promo::query())
            ->through([
                User::class,
                Id::class,
                Customer::class,
                Retailer::class,
                City::class,
                Channel::class,
                Mark::class,
            ])
            ->thenReturn();
        return $promo->first();
    }

    /**
     * @throws Exception
     */
    public function createFromArray(array $data)
    : Promo {
        try {
            $promo = new Promo();
            $promo->fill($data);

            DB::beginTransaction();

            $promo->save();

            switch ($data['promo_type']) {
                case TypeEnum::DISCOUNT->getName():
                    $products = $data['products'];
                    $promo->promo_products()->createMany($products);
                    break;
                case TypeEnum::SALES_PEOPLE_BOOST->getName():
                    $sellers = $data['sellers'];
                    $promo->promo_sellers()->createMany($sellers);
                    break;
                case TypeEnum::RETAILERS_BOOST->getName():
                    dump('RETAILERS_BOOST');
                    break;
                case TypeEnum::GIFT_FOR_PURCHASE->getName():
                    dump('GIFT_FOR_PURCHASE');
                    break;
                case TypeEnum::COVERAGE_INCREASE->getName():
                    dump('COVERAGE_INCREASE');
                    break;
                case TypeEnum::IN_OUT->getName():
                    dump('IN_OUT');
                    break;
            }

            DB::commit();

            return $promo;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Error saving a new Promo: {error}', [
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * @throws Exception
     */
    public function updatePromoProductFromArray(int $promo_id, PromoProduct $promoProduct, array $data)
    : array
    {
        try {
            $promo = Promo::query()->where('id', $promo_id)->first();

            DB::beginTransaction();

            $promoProduct->update($data);

            $promo_with_sum = Promo::query()
                ->where('id', $promo_id)
                ->withSum('promo_products', 'sales_before')
                ->withSum('promo_products', 'sales_plan')
                ->withSum('promo_products', 'sales_on_time')
                ->withSum('promo_products', 'budget_plan')
                ->withSum('promo_products', 'budget_actual')
                ->withSum('promo_products', 'promo_profit')
                ->first();

            $promo->update([
                'total_sales_before'  => $promo_with_sum->promo_products_sum_sales_before,
                'total_sales_plan'    => $promo_with_sum->promo_products_sum_sales_plan,
                'total_sales_on_time' => $promo_with_sum->promo_products_sum_sales_on_time,
                'total_budget_plan'   => $promo_with_sum->promo_products_sum_budget_plan,
                'total_budget_actual' => $promo_with_sum->promo_products_sum_budget_actual,
                'total_promo_profit'  => $promo_with_sum->promo_products_sum_promo_profit,
            ]);

            DB::commit();

            $array['promo'] = $promo->only([
                'total_sales_before',
                'total_sales_plan',
                'total_sales_on_time',
                'total_budget_plan',
                'total_budget_actual',
                'total_promo_profit',
            ]);

            $array['product'] = $promoProduct->only([
                'id',
                'sales_before',
                'sales_plan',
                'sales_on_time',
                'budget_plan',
                'budget_actual',
                'promo_profit',
            ]);

            return $array;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Error updating the Promo with ID={id}. Error: {error}', [
                'id' => $promo_id,
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * @throws Exception
     */
    public function updatePromoMarkFromArray(int $promo_id, PromoMark $promoMark, array $data)
    : ?Promo {
        try {
            $promo = Promo::query()->where('id', $promo_id)->first();

            DB::beginTransaction();

            $avg = round(collect([$data['goals'], $data['sales'], $data['staff']])->avg(), 2);

            $promoMark->update($data);
            $promo->update(['total_mark' => $avg]);

            DB::commit();

            return Promo::query()
                ->where('id', $promo_id)
                ->with('customer')
                ->with('retailer')
                ->with('mark')
                ->with('channel')
                ->first();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Error updating marks for the Promo with ID={id}. Error: {error}', [
                'id'    => $promo_id,
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function getProducts(Promo $promo, array $params = [])
    : Collection {
        request()->merge(['promo_id' => $promo->id, ...$params]);
        $promo_products = app()->make(Pipeline::class)
            ->send(PromoProduct::query())
            ->through([
                PromoId::class,
                Category::class,
                Product::class,
            ])
            ->thenReturn();
        return $promo_products->get();
    }

    /**
     * @throws BindingResolutionException
     */
    public function getSellers(int $promo_id)
    : Collection {
        request()->merge(['promo_id' => $promo_id]);
        $promo_sellers = app()->make(Pipeline::class)
            ->send(PromoSeller::query())
            ->through([
                PromoId::class,
            ])
            ->thenReturn();
        return $promo_sellers->get();
    }
}
