<?php

namespace App\Console\Commands;
use App\Models\Customer;
use Illuminate\Console\Command;
class UpdateCustomerDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-customer-duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decreases the duration by 1 for active users each day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true) {
            // Your logic to update customers here.
            $this->updateCustomerDuration();

            // Sleep for 1 second.
            sleep(1);
        }
    }

    /**
     * Update customer duration logic
     */
    private function updateCustomerDuration()
    {
        $customers = Customer::where('active_status', 'active')->get();

        foreach ($customers as $customer) {
            if ($customer->date_count > 0) {
                $customer->date_count -= 1;
                if ($customer->date_count == 0) {
                    $customer->active_status = 'inactive';
                }
                $customer->save();
            }
        }

        // Output info for debugging
        $this->info('Customer duration updated.');
    }
}
