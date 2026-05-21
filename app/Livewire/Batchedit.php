<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Productadmintab;
use App\Models\BatchProductPrice;
use App\Models\ProductPriceTable;

class Batchedit extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $productId;
    public $product;

    public function mount($id = null)
    {
        $this->productId = $id;

        if ($id) {
            $this->product = Productadmintab::with(['batches', 'prices'])->findOrFail($id);
        }
    }

    private function cleanNumber($value)
    {
        if ($value === null || $value === '') return 0;
        return is_numeric($value) ? $value : preg_replace('/[^0-9.]/', '', $value);
    }

    private function getValue($data, $keys, $default = '')
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && trim($data[$key]) !== '') {
                return trim($data[$key]);
            }
        }
        return $default;
    }

    public function importCsv()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = fopen($this->csvFile->getRealPath(), 'r');

        if (!$file) {
            session()->flash('error', 'CSV file could not be opened.');
            return;
        }

        $header = fgetcsv($file);

        if (!$header) {
            session()->flash('error', 'CSV file is empty.');
            fclose($file);
            return;
        }

        $header = array_map(
            fn($h) => trim(str_replace("\xEF\xBB\xBF", '', $h)),
            $header
        );

        $insertedBatch = 0;
        $updatedBatch  = 0;
        $insertedPrice = 0;
        $updatedPrice  = 0;
        $skipped       = 0;

        while (($row = fgetcsv($file)) !== false) {

            if (count(array_filter($row)) === 0) continue;

            $row  = array_slice(array_pad($row, count($header), ''), 0, count($header));
            $data = array_combine($header, $row);

            $productId  = $this->getValue($data, ['Product ID', 'product_id', 'pid'], $this->productId);
            $batchNoRaw = $this->getValue($data, ['Batch No', 'BatchNo', 'batchno', 'Batch'], '');
            $state      = $this->getValue($data, ['State', 'state'], '');

            if (!$productId || !$batchNoRaw || !$state) {
                $skipped++;
                continue;
            }

            // 1. Find product_batch by batch_number (e.g. "May-01")
            //    If not found, create it so new batches can be added via CSV
            $productBatch = \App\Models\product_batch::firstOrCreate(
                [
                    'product_id'   => $productId,
                    'batch_number' => $batchNoRaw,
                ]
            );

            // 2. Upsert batch_product_prices
            //    Key: pid + batchno (product_batches.id) + state
            $oldBatch = BatchProductPrice::where('pid', $productId)
                ->where('batchno', $productBatch->id)
                ->where('state', $state)
                ->first();

            $batch = BatchProductPrice::updateOrCreate(
                [
                    'pid'     => $productId,
                    'batchno' => $productBatch->id,
                    'state'   => $state,
                ],
                [
                    'boxqty'       => $this->cleanNumber($this->getValue($data, ['Box Qty', 'boxqty', 'Qty'], 0)),
                    'pcsqty'       => $this->cleanNumber($this->getValue($data, ['PCS Qty', 'pcsqty', 'Max Qty'], 0)),
                    'totalqty'     => $this->cleanNumber($this->getValue($data, ['Total Qty', 'Total PCS', 'totalqty'], 0)),
                    'inventoryqty' => $this->cleanNumber($this->getValue($data, ['Inventory', 'Inventory Qty', 'inventoryqty'], 0)),
                ]
            );

            $oldBatch ? $updatedBatch++ : $insertedBatch++;

            // 3. Upsert product_price_tables
            //    Key: pid + state + batchnos (product_batches.id)
            $oldPrice = ProductPriceTable::where('pid', $productId)
                ->where('state', $state)
                ->where('batchnos', $productBatch->id)
                ->first();

            $price = ProductPriceTable::updateOrCreate(
                [
                    'pid'      => $productId,
                    'state'    => $state,
                    'batchnos' => $productBatch->id,
                ],
                [
                    'pricecndf'        => $this->cleanNumber($this->getValue($data, ['CNDF Price', 'pricecndf'], 0)),
                    'pricedistributor' => $this->cleanNumber($this->getValue($data, ['Distributor Price', 'pricedistributor'], 0)),
                    'pricedealer'      => $this->cleanNumber($this->getValue($data, ['Dealer Price', 'pricedealer'], 0)),
                    'pricesubdealer'   => $this->cleanNumber($this->getValue($data, ['Sub Dealer Price', 'pricesubdealer'], 0)),
                    'priceretialer'    => $this->cleanNumber($this->getValue($data, ['Retailer Price', 'priceretialer'], 0)),
                ]
            );

            // 4. Link batch row back to price row
            $batch->update(['priceid' => $price->id]);

            $oldPrice ? $updatedPrice++ : $insertedPrice++;
        }

        fclose($file);
        $this->csvFile = null;

        if ($this->productId) {
            $this->product = Productadmintab::with(['batches', 'prices'])
                ->findOrFail($this->productId);
        }

        session()->flash(
            'success',
            "CSV imported successfully. " .
                "Batch Inserted: {$insertedBatch}, Batch Updated: {$updatedBatch}, " .
                "Price Inserted: {$insertedPrice}, Price Updated: {$updatedPrice}, " .
                "Skipped: {$skipped}"
        );
    }

    public function render()
    {
        return view('livewire.batchedit')->layout('layouts.header');
    }
}
