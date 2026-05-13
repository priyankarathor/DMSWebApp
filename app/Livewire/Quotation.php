<?php

namespace App\Livewire;

use App\Models\orderapprovedtable;
use App\Models\rolediscount;
use App\Models\userhierarchytab;
use Livewire\Component;

class Quotation extends Component
{
    public $productdata;

    public function render()
    {
        $this->productdata = orderapprovedtable::latest()->first();

        if ($this->productdata) {

            $userDiscountRate = 0;
            $roleDiscountRate = 0;

            $userDiscountAmount = 0;
            $roleDiscountAmount = 0;
            $totalDiscount = 0;
            $finalAmount = 0;

            $user = userhierarchytab::where('id', $this->productdata->userid)->first();

            if ($user) {

                /*
                |--------------------------------------------------------------------------
                | USER DISCOUNT
                |--------------------------------------------------------------------------
                | rolediscounts.registerid can match:
                | 1. userhierarchytabs.id
                | 2. userhierarchytabs.registerid
                | 3. orderapprovedtable.userid
                */

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

                /*
                |--------------------------------------------------------------------------
                | ROLE DISCOUNT
                |--------------------------------------------------------------------------
                | Your table image shows role discount saved in `role` column.
                | Example:
                | discount = role
                | role = 8
                | rate = 10
                */

                $roleDiscount = rolediscount::where('discount', 'role')
                    ->where(function ($query) use ($user) {
                        $query->where('role', $user->roleid);

                        if (!empty($user->role)) {
                            $query->orWhere('role', $user->role);
                        }

                        if (!empty($user->userrole)) {
                            $query->orWhere('role', $user->userrole);
                        }
                    })
                    ->first();

                if ($roleDiscount) {
                    $roleDiscountRate = (float) $roleDiscount->rate;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | AMOUNT CALCULATION
            |--------------------------------------------------------------------------
            */

            $amounts = !empty($this->productdata->amount)
                ? array_map('trim', explode(',', $this->productdata->amount))
                : [];

            $subTotal = array_sum(array_map('floatval', $amounts));

            $cgst = !empty($this->productdata->cgst)
                ? array_sum(array_map('floatval', explode(',', $this->productdata->cgst)))
                : ($subTotal * 0.09);

            $sgst = !empty($this->productdata->sgst)
                ? array_sum(array_map('floatval', explode(',', $this->productdata->sgst)))
                : ($subTotal * 0.09);

            $grandTotalBeforeDiscount = $subTotal + $cgst + $sgst;

            /*
            |--------------------------------------------------------------------------
            | DISCOUNT CALCULATION
            |--------------------------------------------------------------------------
            */

            $userDiscountAmount = ($grandTotalBeforeDiscount * $userDiscountRate) / 100;
            $roleDiscountAmount = ($grandTotalBeforeDiscount * $roleDiscountRate) / 100;

            $totalDiscount = $userDiscountAmount + $roleDiscountAmount;
            $finalAmount = $grandTotalBeforeDiscount - $totalDiscount;

            /*
            |--------------------------------------------------------------------------
            | PASS DATA TO BLADE
            |--------------------------------------------------------------------------
            */

            $this->productdata->sub_total = $subTotal;
            $this->productdata->cgst_total = $cgst;
            $this->productdata->sgst_total = $sgst;
            $this->productdata->grand_total_before_discount = $grandTotalBeforeDiscount;

            $this->productdata->user_discount_rate = $userDiscountRate;
            $this->productdata->role_discount_rate = $roleDiscountRate;

            $this->productdata->user_discount_amount = $userDiscountAmount;
            $this->productdata->role_discount_amount = $roleDiscountAmount;

            $this->productdata->total_discount = $totalDiscount;
            $this->productdata->final_amount = $finalAmount;
        }

        return view('livewire.quotation', [
            'productdata' => $this->productdata
        ])->layout('layouts.header');
    }   
}