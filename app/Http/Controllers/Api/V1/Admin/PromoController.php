<?php

declare(strict_types=1);

// 08.11.2024 at 00:24:23
namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\Promo\TypeEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Promo\PromoStatusUpdateRequest;
use App\Http\Resources\V1\Promo\PromoCollection;
use App\Http\Resources\V1\Promo\PromoFullResource;
use App\Http\Resources\V1\Promo\PromoResource;
use App\Models\Promo;
use App\Services\Promos\PromoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

final class PromoController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly PromoService $promoService,
    ) {
    }

    public function index()
    : JsonResponse
    {
        $this->authorize('viewAny', Promo::class);

        $promos = $this->promoService->getPromos([
            'customer' => true,
            'retailer' => true,
            'user'     => true,
        ]);

        return $this->successResponse(
            new PromoCollection($promos),
            'success',
            __(''),
        );
    }

    public function show(Promo $promo)
    : JsonResponse {
        $this->authorize('view', $promo);

        $promo = $this->promoService->findPromo($promo, [
            'customer'       => true,
            'retailer'       => true,
            'city'           => true,
            'channel'        => true,
            'mark'           => true,
            'user'           => true,
            'promo_products' => false,
            'promo_sellers'  => false,
        ]);

        return $this->successResponse(
            new PromoFullResource($promo),
            'success',
            __(''),
        );
    }

    public function update(PromoStatusUpdateRequest $request, Promo $promo)
    : JsonResponse {
        $data = $request->validated();
        $promo = $this->promoService->updatePromoStatus($promo, $data);

        return $this->successResponse(
            new PromoResource($promo),
            'success',
            __('crud.promos.status_updated'),
        );
    }

    public function print(Promo $promo)
    {
        $promoObj = $this->promoService->findPromo($promo, [
            'customer'       => true,
            'retailer'       => true,
            'city'           => true,
            'channel'        => true,
            'mark'           => true,
            'promo_products' => true,
            'promo_sellers'  => true,
        ]);

        /*echo '<pre>';
        print_r($promoObj);
        echo '</pre>';
        return;*/

        if (count($promoObj->promo_sellers) > 0) {
            $sellers = $this->promoService->getPromoSellers([
                'promo_id'        => $promoObj->id,
                'customer_seller' => true,
            ])->toArray();

            $supervisors = [];

            foreach ($sellers as $seller) {
                if ($seller['is_supervisor']) {
                    $supervisors[$seller['seller_id']] = $seller;
                }
            }

            foreach ($supervisors as $seller_id => $supervisor) {
                foreach ($sellers as $seller) {
                    if ($seller_id == $seller['supervisor_id']) {
                        $supervisors[$seller_id]['sellers'][] = $seller;
                    }
                }
            }

            $supervisors = array_map(function ($seller) {
                return [
                    'supervisor' => $this->process_data($seller),
                    'sellers'    => array_map(function ($item) {
                        return $this->process_data($item);
                    }, $seller['sellers']),
                ];
            }, $supervisors);

            /*echo '<pre>';
            print_r($supervisors);
            echo '</pre>';
            return;*/
        }

        if (count($promoObj->promo_products) > 0) {
            $products = $this->promoService->getPromoProducts(
                $promoObj,
                [
                    'category' => true,
                    'product'  => true,
                ],
            )->toArray();

            $products = array_map(function ($product) {
                return [
                    'name'          => $product['category']['name'] . "\n" . $product['product']['name'],
                    'promo_price'   => $product['promo_price'],
                    'discount'      => $product['discount'],
                    'net_profit'    => $product['net_profit'],
                    'compensation'  => $product['compensation'],
                    'sales_before'  => formatNumberRU($product['sales_before']),
                    'sales_plan'    => formatNumberRU($product['sales_plan']),
                    'sales_on_time' => formatNumberRU($product['sales_on_time']),
                    'budget_plan'   => formatNumberRU($product['budget_plan']),
                    'budget_actual' => formatNumberRU($product['budget_actual']),

                    /*"surplus_plan" => "147.00"
                    "surplus_actual" => "217.00"
                    "revenue_plan" => "13922.00"
                    "revenue_actual" => "17899.00"

                    "profit_per_unit" => "8.33"
                    "profit_per_product_plan" => "3207.05"
                    "profit_per_product_actual" => "4123.35"*/
                ];
            }, $products);
        }

        unset($promoObj->promo_sellers);
        unset($promoObj->promo_products);

        $promo = $promoObj->toArray();

        $promo['type'] = TypeEnum::from($promo['promo_type'])->promoTypeCode()
            . ' | '
            . TypeEnum::from($promo['promo_type'])->label();
        $promo['distributor'] = $promo['customer']['name'];
        $promo['city'] = $promo['city']['name'];
        $promo['retailer'] = $promo['retailer'] ? ' | ' . $promo['retailer']['name'] : '';
        $promo['channel'] = $promo['channel']['name'] . $promo['retailer'];
        $promo['start_date'] = Carbon::createFromDate($promo['start_date'])->format('d.m.Y');
        $promo['end_date'] = Carbon::createFromDate($promo['end_date'])->format('d.m.Y');
        $promo['total_budget_plan'] = formatNumberRU($promo['total_budget_plan']);
        $promo['total_promo_profit_plan'] = formatNumberRU($promo['total_promo_profit_plan']);

        $pdf = PDF::loadView('Admin.pdf.promo', [
            'promo'    => $promo,
            'products' => $products ?? [],
            'sellers'  => $supervisors ?? [],
        ]);

        return $pdf->stream('export.pdf');
    }

    private function process_data(array $arr)
    : array {
        return [
            'id'             => $arr['id'],
            'seller_id'      => $arr['seller_id'],
            'supervisor_id'  => $arr['supervisor_id'],
            'is_supervisor'  => $arr['is_supervisor'],
            'name'           => $arr['customer_seller']['name'],
            'compensation'   => $arr['compensation'],
            'sales_before'   => formatNumberRU($arr['sales_before']),
            'sales_plan'     => formatNumberRU($arr['sales_plan']),
            'sales_after'    => formatNumberRU($arr['sales_after']),
            'surplus_plan'   => formatNumberRU($arr['surplus_plan']),
            'surplus_actual' => formatNumberRU($arr['surplus_actual']),
            'budget_plan'    => formatNumberRU($arr['budget_plan']),
            'budget_actual'  => formatNumberRU($arr['budget_actual']),
        ];
    }
}
