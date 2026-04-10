<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Productadmintab;
use App\Models\BatchProductPrice;
use App\Models\ProductPriceTable;
use Illuminate\Support\Facades\DB;

class ProductCsvImport extends Component
{
    use WithFileUploads;

    public $csv;

    public function import()
    {
        $this->validate([
            'csv' => 'required|mimes:csv,txt',
        ]);

        DB::beginTransaction();

        try {
            $path = $this->csv->getRealPath();
            $file = fopen($path, 'r');

            $header = fgetcsv($file);

            if (!$header) {
                throw new \Exception('CSV file is empty.');
            }

            $header = array_map(fn($item) => strtolower(trim($item)), $header);

            while (($row = fgetcsv($file, 10000, ',')) !== false) {
                if (count($row) !== count($header)) {
                    continue;
                }

                $data = array_combine($header, $row);

                $productName       = trim($data['product name'] ?? '');
                $description       = trim($data['description'] ?? '');
                $productPrice      = trim($data['product price'] ?? '');
                $category          = trim($data['category'] ?? '');
                $fileValue         = trim($data['file'] ?? '');
                $image             = trim($data['image'] ?? '');
                $quantity          = trim($data['quantity'] ?? '');
                $weightNum         = trim($data['weight num'] ?? '');
                $weightClass       = trim($data['weight class'] ?? '');
                $hsnCode           = trim($data['hsn code'] ?? '');
                $link              = trim($data['link'] ?? '');
                $metaTag           = trim($data['meta tag'] ?? '');
                $metaKeyword       = trim($data['meta keyword'] ?? '');
                $metaDescription   = trim($data['meta description'] ?? '');
                $action            = trim($data['action'] ?? '');

                $batchNo           = trim($data['batch no'] ?? '');
                $qty               = trim($data['qty'] ?? '');
                $maxQty            = trim($data['max qty'] ?? '');

                $state             = trim($data['state'] ?? '');
                $priceCndf         = trim($data['price cndf'] ?? '');
                $priceDistributor  = trim($data['price distributor'] ?? '');
                $priceDealer       = trim($data['price dealer'] ?? '');
                $priceSubDealer    = trim($data['price sub dealer'] ?? '');
                $priceRetailer     = trim($data['price retailer'] ?? '');

                // product unique check
                $product = Productadmintab::where('productname', $productName)
                    ->where('category', $category)
                    ->where('hsncode', $hsnCode)
                    ->first();

                if (!$product) {
                    $product = Productadmintab::create([
                        'productname'      => $productName,
                        'description'      => $description,
                        'productprice'     => $productPrice,
                        'category'         => $category,
                        'file'             => $fileValue,
                        'image'            => $image,
                        'quantity'         => $quantity,
                        'weightnum'        => $weightNum,
                        'weihgtclass'      => $weightClass,
                        'hsncode'          => $hsnCode,
                        'link'             => $link,
                        'metatag'          => $metaTag,
                        'metakeyword'      => $metaKeyword,
                        'metadescription'  => $metaDescription,
                        'Action'           => $action,
                    ]);
                }

                // batch wise insert
                $batchExists = BatchProductPrice::where('pid', $product->id)
                    ->where('batchno', $batchNo)
                    ->exists();

                if (!$batchExists) {
                    BatchProductPrice::create([
                        'pid'     => $product->id,
                        'batchno' => $batchNo,
                        'qty'     => $qty,
                        'maxqty'  => $maxQty,
                    ]);
                }

                // IMPORTANT:
                // product_price_tables me row alag banegi jab price change hoga
                // group by: pid + state + all price columns

                $currentBatch = "'" . $batchNo . "'";

                $priceRow = ProductPriceTable::where('pid', $product->id)
                    ->where('state', $state)
                    ->where('pricecndf', $priceCndf)
                    ->where('pricedistributor', $priceDistributor)
                    ->where('pricedealer', $priceDealer)
                    ->where('pricesubdealer', $priceSubDealer)
                    ->where('priceretialer', $priceRetailer)
                    ->first();

                if ($priceRow) {
                    $existingBatchnos = trim((string) $priceRow->batchnos);

                    if (empty($existingBatchnos)) {
                        $newBatchnos = $currentBatch;
                    } else {
                        $existingArray = array_map('trim', explode(',', $existingBatchnos));

                        if (!in_array($currentBatch, $existingArray)) {
                            $newBatchnos = $existingBatchnos . ',' . $currentBatch;
                        } else {
                            $newBatchnos = $existingBatchnos;
                        }
                    }

                    $priceRow->update([
                        'batchnos' => $newBatchnos,
                    ]);
                } else {
                    ProductPriceTable::create([
                        'pid'               => $product->id,
                        'state'             => $state,
                        'pricecndf'         => $priceCndf,
                        'pricedistributor'  => $priceDistributor,
                        'pricedealer'       => $priceDealer,
                        'pricesubdealer'    => $priceSubDealer,
                        'priceretialer'     => $priceRetailer,
                        'batchnos'          => $currentBatch,
                    ]);
                }
            }

            fclose($file);

            DB::commit();

            session()->flash('success', 'CSV imported successfully.');
            $this->reset('csv');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product-csv-import')->layout('layouts.header');
    }
}