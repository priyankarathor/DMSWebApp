<?php

namespace App\Imports;

use App\Models\Productadmintab;
use App\Models\BatchProductPrice;
use App\Models\ProductPriceTable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCsvImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                $productName      = trim($row['product_name'] ?? '');
                $category         = trim($row['product_category'] ?? '');
                $batchNo          = trim($row['batch_no'] ?? '');
                $measurement      = trim($row['measurement'] ?? '');
                $totalBox         = trim($row['total_box'] ?? '');
                $perBoxSinglePcs  = trim($row['per_box_single_pcs'] ?? '');
                $hsnNumber        = trim($row['hsn_number'] ?? '');
                $imgLink          = trim($row['img_link'] ?? '');
                $description      = trim($row['description'] ?? '');
                $state            = trim($row['state'] ?? '');
                $priceCndf        = trim($row['price_cndf'] ?? '');
                $priceDistributor = trim($row['price_distributor'] ?? '');
                $priceDealer      = trim($row['price_dealer'] ?? '');
                $priceSubDealer   = trim($row['price_sub_dealer'] ?? '');
                $priceRetailer    = trim($row['price_retailer'] ?? '');
                $totalQty         = trim($row['total_qty'] ?? '');

                // empty row skip
                if (empty($productName) && empty($category) && empty($batchNo)) {
                    continue;
                }

                // maxqty calculate
                $maxQty = 0;
                if (is_numeric($totalBox) && is_numeric($perBoxSinglePcs)) {
                    $maxQty = (int)$totalBox * (int)$perBoxSinglePcs;
                }

                // 1) Unique product insert in productadmintabs
                $product = Productadmintab::firstOrCreate(
                    [
                        'productname' => $productName,
                        'category'    => $category,
                        'quantity'    => $measurement,
                    ],
                    [
                        'boxquantity' => $totalBox,
                        'hsnnumber'   => $hsnNumber,
                        'file'        => $imgLink,
                        'description' => $description,
                    ]
                );

                // optional: update master fields if already exists
                $product->update([
                    'boxquantity' => $totalBox,
                    'hsnnumber'   => $hsnNumber,
                    'file'        => $imgLink,
                    'description' => $description,
                ]);

                // 2) batch_product_prices insert/update
                if (!empty($batchNo)) {
                    BatchProductPrice::updateOrCreate(
                        [
                            'pid'     => $product->id,
                            'batchno' => $batchNo,
                        ],
                        [
                            'qty'    => $totalQty,
                            'maxqty' => $maxQty,
                        ]
                    );
                }

                // 3) product_price_tables insert/update
                if (!empty($state)) {
                    ProductPriceTable::updateOrCreate(
                        [
                            'pid'   => $product->id,
                            'state' => $state,
                        ],
                        [
                            'pricecndf'        => $priceCndf,
                            'pricedistributor' => $priceDistributor,
                            'pricedealer'      => $priceDealer,
                            'pricesubdealer'   => $priceSubDealer,
                            'priceretialer'    => $priceRetailer,
                        ]
                    );
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}