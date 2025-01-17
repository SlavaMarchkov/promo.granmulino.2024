<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CustomerSeller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeSellersCommand extends Command
{
    protected $signature = 'make:sellers';

    protected $description = 'Creates sellers and supervisors for a Customer';

    public function handle()
    : void
    {
        $customer_id = $this->ask('Enter the Customer ID?');
        $supervisors_number = $this->ask('Enter the number of Supervisors');
//        $supervisor_name = $this->anticipate('Enter the name of a Supervisor', ['Супервайзер', 'Supervisor']);
        $supervisor_name = $this->choice('Choose the name of a Supervisor', ['Супервайзер', 'Supervisor'], 0);
        $sellers_number = $this->ask('Enter the number of Sellers for each Supervisor');
//        $seller_name = $this->anticipate('Enter the name of a Seller', ['Торговый представитель', 'Trade Seller']);
        $seller_name = $this->choice('Choose the name of a Seller', ['Торговый представитель', 'Trade Seller'], 0);

        if ($this->confirm('Do you wish to run the process?')) {
            // $deleted_rows = DB::delete('delete from customer_sellers where customer_id = ?', [$customer_id]);
            $deleted_rows = DB::table('customer_sellers')
                ->where('customer_id', $customer_id)
                ->delete();

            for ($i = 0; $i < $supervisors_number; $i++) {
                $supervisor = CustomerSeller::create([
                    'name'          => $supervisor_name . '_' . $i + 1,
                    'customer_id'   => $customer_id,
                    'supervisor_id' => null,
                    'is_active'     => true,
                    'is_supervisor' => true,
                ]);

                $supervisor_id = $supervisor->id;

                for ($j = 0; $j < $sellers_number; $j++) {
                    CustomerSeller::create([
                        'name'          => $seller_name . '_' . $j + 1 . '_' . $i + 1,
                        'customer_id'   => $customer_id,
                        'supervisor_id' => $supervisor_id,
                        'is_active'     => true,
                        'is_supervisor' => false,
                    ]);
                }
            }
            $this->info('Sellers have been created! Deleted records: ' . $deleted_rows);
        } else {
            $this->line('Cancelled');
        }
    }
}
