<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderapprovedtable extends Model
{
    use HasFactory;

    protected $table = 'orderapprovedtables';

    protected $fillable = [
        'approveuserid',
        'invoiceno',
        'invoicedate',
        'framname',
        'gstnumber',
        'username',
        'contactno',
        'email',
        'region',
        'address',
        'productname',
        'productquantity',
        'productbulk',
        'amount',
        'totalamount',
        'gstrate',
        'selectgst',
        'sgst',
        'cgst',
        'created_at',
        'updated_at',
        'sellerid'
    ];
}