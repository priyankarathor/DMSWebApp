<?php

namespace App\Livewire;

use App\Models\orderlisttab;
use App\Models\productjunction;
use App\Models\userroletab;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\manageaccounttable;
use App\Models\orderapprovedtable;
use App\Models\rolediscount;
use App\Models\batchProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Orderapprove extends Component
{
    public $value;
    public $userid;
    public $products = [];
    public $lastnum;

    public $discountRate = 0;
    public $discountType = 'none';
    public $userDiscountRate = 0;
    public $roleDiscountRate = 0;

    public function mount($id)
    {
        $this->value = orderlisttab::find($id);

        if (!$this->value) {
            abort(404);
        }

        $this->userid = userhierarchytab::find($this->value->userid);

        $this->loadDiscount();
        $this->loadProducts();
    }

    private function csvArray($value)
    {
        if (is_array($value)) {
            return array_map('trim', $value);
        }

        return array_map('trim', explode(',', (string) $value));
    }

    private function loadDiscount()
    {
        if (!$this->userid) {
            return;
        }

        $discountData = $this->getDiscountDetailsByUserId($this->userid->id);

        $this->userDiscountRate = $discountData['user_discount'];
        $this->roleDiscountRate = $discountData['role_discount'];
        $this->discountRate = $discountData['total_discount'];

        if ($this->userDiscountRate > 0 && $this->roleDiscountRate > 0) {
            $this->discountType = 'user + role';
        } elseif ($this->userDiscountRate > 0) {
            $this->discountType = 'user';
        } elseif ($this->roleDiscountRate > 0) {
            $this->discountType = 'role';
        } else {
            $this->discountType = 'none';
        }
    }

    private function getDiscountDetailsByUserId($userid)
    {
        $user = userhierarchytab::find($userid);

        if (!$user) {
            return [
                'user_discount' => 0,
                'role_discount' => 0,
                'total_discount' => 0,
            ];
        }

        $userDiscountRate = 0;
        $roleDiscountRate = 0;

        // User discount
        $userDiscount = rolediscount::where('discount', 'user')
            ->where(function ($query) use ($user) {
                $query->where('registerid', $user->id);

                if (!empty($user->registerid)) {
                    $query->orWhere('registerid', $user->registerid);
                }
            })
            ->first();

        if ($userDiscount) {
            $userDiscountRate = (float) $userDiscount->rate;
        }

        // Role discount
        $roleDiscount = rolediscount::where('discount', 'role')
            ->where('role', $user->roleid)
            ->first();

        if ($roleDiscount) {
            $roleDiscountRate = (float) $roleDiscount->rate;
        }

        return [
            'user_discount' => $userDiscountRate,
            'role_discount' => $roleDiscountRate,
            'total_discount' => $userDiscountRate + $roleDiscountRate,
        ];
    }

    private function loadProducts()
    {
        $productIds      = $this->csvArray($this->value->pid);
        $statuses        = $this->csvArray($this->value->orderstatus);
        $bulkQuantities  = $this->csvArray($this->value->productbulk);
        $quentity        = $this->csvArray($this->value->productbulk);
        $totalQty        = $this->csvArray($this->value->totalqty);
        $measurements    = $this->csvArray($this->value->qtymasurment);
        $prices          = $this->csvArray($this->value->price);
        $priceIds        = $this->csvArray($this->value->priceId);
        $batchIds        = $this->csvArray($this->value->batchId);

        $this->products = [];

        foreach ($productIds as $index => $pid) {
            if (($statuses[$index] ?? '') !== 'Approve') {
                continue;
            }

            $product = productadmintab::find($pid);

            if ($product) {
                $product->bulk_quantity  = $bulkQuantities[$index] ?? 0;
                $product->bulk_total     = $totalQty[$index] ?? 0;
                $product->bulk_masurment = $measurements[$index] ?? '';
                $product->bulk_price     = $prices[$index] ?? 0;
                $product->price_id       = $priceIds[$index] ?? null;
                $product->batch_id       = $batchIds[$index] ?? null;
                $product->product_quantity = $quentity[$index] ?? '';

                $this->products[] = $product;
            }
        }
    }

    public function render()
    {
        $authUser = auth()->user();

        $manageuser = null;

        if ($authUser) {
            $manageuser = manageaccounttable::where('email', $authUser->email)->first();
        }

        $this->lastnum = orderapprovedtable::latest()->first();

        return view('livewire.orderapprove', [
            'tab' => userroletab::all(),
            'users' => $manageuser,
            'discountRate' => $this->discountRate,
            'discountType' => $this->discountType,
            'userDiscountRate' => $this->userDiscountRate,
            'roleDiscountRate' => $this->roleDiscountRate,
        ])->layout('layouts.header');
    }

    public function insertdistributerdata(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $order = orderlisttab::findOrFail($id);

            $priceIds = $this->csvArray($order->priceId);
            $batchIds = $this->csvArray($order->batchId);

            $pridList        = $request->input('prid', []);
            $productNames    = $request->input('productname', []);
            $productquantity = $request->input('productquantity', []);
            $bulkmasurment   = $request->input('bulkmasurment', []);
            $bulktotalqty    = $request->input('bulktotalqty', []);
            $productbulkList = $request->input('productbulk', []);
            $gstrate         = $request->input('gstrate', []);
            $sgst            = $request->input('sgst', []);
            $cgst            = $request->input('cgst', []);
            $igst            = $request->input('igst', []);
            $amount          = $request->input('amount', []);
            $hsn             = $request->input('hsn', []);
            $selectgst       = $request->input('selectgst', []);
            $totalamount     = $request->input('totalamount', []);

            $discountData = $this->getDiscountDetailsByUserId($request->userid);

            $ordervalue = new orderapprovedtable();

            // user discount + role discount
            $ordervalue->discount = $discountData['total_discount'];

            $ordervalue->approveuserid = $request->adminid;
            $ordervalue->invoiceno = $request->invoicenum;
            $ordervalue->invoicedate = $request->invoicedate;
            $ordervalue->framname = $request->framname;
            $ordervalue->gstnumber = $request->gstnumber;
            $ordervalue->username = $request->username;
            $ordervalue->contactno = $request->contactno;
            $ordervalue->email = $request->email;
            $ordervalue->region = $request->region;
            $ordervalue->address = $request->address;
            $ordervalue->userrole = $request->userrole;
            $ordervalue->drivername = $request->drivername;
            $ordervalue->drivercompany = $request->drivercompany;
            $ordervalue->vehicleno = $request->vehicleno;
            $ordervalue->drivercontact = $request->drivercontact;
            $ordervalue->udyamno = $request->udyamno;
            $ordervalue->roleid = $request->roleid;
            $ordervalue->userid = $request->userid;

            $ordervalue->priceid = implode(',', $priceIds);
            $ordervalue->batchid = implode(',', $batchIds);
            $ordervalue->productid = implode(',', $pridList);
            $ordervalue->productname = implode(',', $productNames);

            // weightclass removed
            $ordervalue->productquantity = implode(',', $productquantity);

            $ordervalue->measurement = implode(',', $bulkmasurment);
            $ordervalue->totalpcs = implode(',', $bulktotalqty);
            $ordervalue->productbulk = implode(',', $productbulkList);
            $ordervalue->gstrate = implode(',', $gstrate);
            $ordervalue->sgst = implode(',', $sgst);
            $ordervalue->cgst = implode(',', $cgst);
            $ordervalue->igst = implode(',', $igst);
            $ordervalue->amount = implode(',', $amount);
            $ordervalue->hsnno = implode(',', $hsn);
            $ordervalue->selectgst = implode(',', $selectgst);
            $ordervalue->totalamount = implode(',', $totalamount);

            $ordervalue->sellerid = $request->adminid;
            $ordervalue->save();

            foreach ($pridList as $index => $prid) {
                $currentProductBulk = (float) ($productbulkList[$index] ?? 0);
                $currentPriceId = $priceIds[$index] ?? null;
                $currentBatchId = $batchIds[$index] ?? null;

                $existingRecord = productjunction::where('rid', $request->roleid)
                    ->where('uid', $request->userid)
                    ->where('pid', $prid)
                    ->where('priceid', $currentPriceId)
                    ->where('batchid', $currentBatchId)
                    ->first();

                if ($existingRecord) {
                    $existingRecord->inventery += $currentProductBulk;
                    $existingRecord->save();
                } else {
                    productjunction::create([
                        'rid' => $request->roleid,
                        'uid' => $request->userid,
                        'pid' => $prid,
                        'inventery' => $currentProductBulk,
                        'priceid' => $currentPriceId,
                        'batchid' => $currentBatchId,
                        'sellerid' => $request->adminid
                    ]);
                }

                if (!empty($currentBatchId)) {
                    $batchProduct = batchProductPrice::find($currentBatchId);

                    if ($batchProduct) {
                        $batchProduct->inventoryqty = max(
                            0,
                            (float) $batchProduct->inventoryqty - $currentProductBulk
                        );

                        $batchProduct->save();
                    }
                }
            }

            $this->removeApprovedItems($order);
        });

        return redirect('Quotationinvoicedata');
    }

    private function removeApprovedItems($order)
    {
        $fields = [
            'pid',
            'orderstatus',
            'productbulk',
            'totalqty',
            'qtymasurment',
            'price',
            'priceId',
            'batchId',
        ];

        $fieldData = [];

        foreach ($fields as $field) {
            $fieldData[$field] = $this->csvArray($order->$field);
        }

        $filtered = array_fill_keys($fields, []);

        foreach ($fieldData['orderstatus'] as $index => $status) {
            if (trim($status) !== 'Approve') {
                foreach ($fields as $field) {
                    $filtered[$field][] = $fieldData[$field][$index] ?? '';
                }
            }
        }

        if (!empty(array_filter($filtered['pid']))) {
            foreach ($fields as $field) {
                $order->$field = implode(',', $filtered[$field]);
            }

            $order->save();
        } else {
            $order->delete();
        }
    }

    public function deletedata($id)
    {
        orderapprovedtable::where('id', $id)->delete();

        return back();
    }
}