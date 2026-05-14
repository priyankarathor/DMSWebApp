<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\productadmintab as Productadmintab;
use App\Models\batchProductPrice as BatchProductPrice;
use App\Models\productPriceTable as ProductPriceTable;
use App\Models\brand;
use App\Models\categorytable;
use Illuminate\Support\Facades\DB;

class ProductCsvImport extends Component
{
    use WithFileUploads;

    public $csv;
    public $selectedCategoryId = '';
    public $selectedBrandId = '';

    public function import()
    {
        $this->validate([
            'csv' => 'required|mimes:csv,txt',
            'selectedCategoryId' => 'required',
            'selectedBrandId' => 'required',
        ]);

        $selectedCategory = categorytable::find($this->selectedCategoryId);
        $selectedBrand = brand::find($this->selectedBrandId);

        if (!$selectedCategory || !$selectedBrand) {
            session()->flash('error', 'Invalid category or brand selected.');
            return;
        }

        DB::beginTransaction();

        try {
            $file = fopen($this->csv->getRealPath(), 'r');

            if (!$file) {
                throw new \Exception('Unable to open CSV file.');
            }

            $header = fgetcsv($file);

            if (!$header) {
                throw new \Exception('CSV file is empty.');
            }

            $header = array_map(function ($item) {
                return strtolower(trim($this->cleanCsvValue($item)));
            }, $header);

            while (($row = fgetcsv($file, 10000, ',')) !== false) {
                if (count($row) !== count($header)) {
                    continue;
                }

                $row = array_map(function ($value) {
                    return $this->cleanCsvValue($value);
                }, $row);

                $data = array_combine($header, $row);

                if (!$data) {
                    continue;
                }

                $productName = $data['product name'] ?? '';
                $description = $data['description'] ?? '';
                $productPrice = $data['product cost price'] ?? $data['product price'] ?? '';

                $category = $selectedCategory->value;
                $brandName = $selectedBrand->brandName;

                $fileValue = $data['file'] ?? '';
                $image = $data['image'] ?? '';
                $quantity = $data['quantity'] ?? '';
                $weightNum = $data['weight num'] ?? '';
                $weightClass = $data['weight class'] ?? '';
                $hsnCode = $data['hsn code'] ?? '';
                $dp = $data['dp'] ?? '';
                $mop = $data['mop'] ?? '';
                $mrp = $data['mrp'] ?? '';
                $link = $data['link'] ?? '';
                $metaTag = $data['meta tag'] ?? '';
                $metaKeyword = $data['meta keyword'] ?? '';
                $metaDescription = $data['meta description'] ?? '';
                $action = $data['action'] ?? 'Active';

                $batchNo = trim($data['batch no'] ?? '');

                $boxqty = (int) ($data['box qty'] ?? $data['qty'] ?? 0);
                $pcsqty = (int) ($data['pcs qty'] ?? $data['max qty'] ?? 0);

                $totalqty = $boxqty * $pcsqty;
                $inventoryqty = $totalqty;

                $state = trim($data['state'] ?? '');

                $priceCndf = $this->cleanPrice($data['price cndf'] ?? 0);
                $priceDistributor = $this->cleanPrice($data['price distributor'] ?? 0);
                $priceDealer = $this->cleanPrice($data['price dealer'] ?? 0);
                $priceSubDealer = $this->cleanPrice($data['price sub dealer'] ?? 0);
                $priceRetailer = $this->cleanPrice($data['price retailer'] ?? 0);

                if (empty($productName) && empty($hsnCode)) {
                    continue;
                }

                $product = Productadmintab::updateOrCreate(
                    [
                        'productname' => $productName,
                        'category' => $category,
                        'hsncode' => $hsnCode,
                    ],
                    [
                        'description' => $description,
                        'productprice' => $productPrice,
                        'brand' => $brandName,
                        'file' => $fileValue,
                        'image' => $image,
                        'quantity' => $quantity,
                        'weightnum' => $weightNum,
                        'weihgtclass' => $weightClass,
                        'dp' => $dp,
                        'mop' => $mop,
                        'mrp' => $mrp,
                        'link' => $link,
                        'metatag' => $metaTag,
                        'metakeyword' => $metaKeyword,
                        'metadescription' => $metaDescription,
                        'Action' => $action,
                        'categoryid' => $this->selectedCategoryId,
                        'brandid' => $this->selectedBrandId,
                    ]
                );

                $batch = null;

                if (!empty($batchNo)) {
                    $batch = BatchProductPrice::updateOrCreate(
                        [
                            'pid' => $product->id,
                            'batchno' => $batchNo,
                        ],
                        [
                            'boxqty' => $boxqty,
                            'pcsqty' => $pcsqty,
                            'totalqty' => $totalqty,
                            'inventoryqty' => $inventoryqty,
                        ]
                    );
                }

                if (!empty($state) && $batch) {
                    $priceRow = ProductPriceTable::updateOrCreate(
                        [
                            'pid' => $product->id,
                            'state' => $state,
                            'batchnos' => $batch->id,
                        ],
                        [
                            'pricecndf' => $priceCndf,
                            'pricedistributor' => $priceDistributor,
                            'pricedealer' => $priceDealer,
                            'pricesubdealer' => $priceSubDealer,
                            'priceretialer' => $priceRetailer,
                        ]
                    );

                    $batch->priceid = $priceRow->id;
                    $batch->save();
                }
            }

            fclose($file);
            DB::commit();

            session()->flash('success', 'CSV imported successfully with batch id in price table.');
            $this->reset('csv');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function exportCsv()
    {
        $this->validate([
            'selectedCategoryId' => 'required',
            'selectedBrandId' => 'required',
        ]);

        $category = categorytable::find($this->selectedCategoryId);
        $brand = brand::find($this->selectedBrandId);

        $columns = [
            'Category ID',
            'Category',
            'Brand ID',
            'Brand',
            'Product name',
            'Description',
            'Product Cost price',
            'File',
            'Image',
            'Quantity',
            'Weight num',
            'Weight class',
            'Hsn code',
            'Dp',
            'Mop',
            'Mrp',
            'Link',
            'Meta tag',
            'Meta keyword',
            'Meta description',
            'Action',
            'Batch no',
            'Box qty',
            'Pcs qty',
            'State',
            'Price cndf',
            'Price distributor',
            'Price dealer',
            'Price sub dealer',
            'Price retailer',
        ];

        $sampleRow = [
            $this->selectedCategoryId,
            $category->value ?? '',
            $this->selectedBrandId,
            $brand->brandName ?? '',
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
            '', '', '', '', '', '', '', '', '',
        ];

        return response()->streamDownload(function () use ($columns, $sampleRow) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns);
            fputcsv($file, $sampleRow);

            fclose($file);
        }, 'product_format.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function cleanCsvValue($value)
    {
        $value = trim((string) $value);
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');

        return str_replace(["\xC2\xA0", "\r", "\n"], [' ', ' ', ' '], $value);
    }

    private function cleanPrice($value)
    {
        $value = str_replace([',', '₹', 'Rs.', 'rs.', ' '], '', (string) $value);

        return is_numeric($value) ? $value : 0;
    }

    public function render()
    {
        return view('livewire.product-csv-import', [
            'brand' => brand::get(),
            'category' => categorytable::where('type', '!=', 'master')->get(),
        ])->layout('layouts.header');
    }
}