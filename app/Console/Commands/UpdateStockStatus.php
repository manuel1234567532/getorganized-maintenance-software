<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SparePart;
class UpdateStockStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $spareParts = SparePart::all();

        foreach ($spareParts as $sparePart) {
            $this->info('Processing Spare Part: ' . $sparePart->id);

            if ($sparePart->current_stock < $sparePart->minimum_stock && $sparePart->current_stock > 0) {
                $sparePart->status = 'minimum_reached';
            } elseif ($sparePart->current_stock <= 0) {
                $sparePart->status = 'out_of_stock';
            } else {
                $sparePart->status = 'in_stock';
            }

            $sparePart->save();
            $this->info('Status updated for Spare Part: ' . $sparePart->id);
        }

        $this->info('Stock status update process completed.');
    }

}
