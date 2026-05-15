<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\productjunction;
use App\Models\orderapprovedtable;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Distributerorderlist extends Component
{
    public function render()
    {
        $product = productadmintab::get();
        $users = userhierarchytab::get();
        $data = orderlisttab::get();
        $roles = userroletab::get();
        return view('livewire.distributerorderlist', ['tab' => $data, 'products' => $product, 'userdata' => $users, 'roles' => $roles])->layout('layouts.header');
    }

    public function getapporder(Request $data)
    {
        $orderdata = new orderlisttab();

        $orderdata->userid = $data->userid;
        $orderdata->orderstatus = $data->orderstatus;
        $orderdata->productbulk = $data->productbulk;
        $orderdata->qtymasurment = $data->qtymasurment;
        $orderdata->totalqty = $data->totalqty;
        $orderdata->pid = $data->pid;
        $orderdata->price = $data->price;
        $orderdata->totalPrice = $data->totalPrice;
        $orderdata->grandTotal = $data->grandTotal;
        $orderdata->priceId = $data->priceId;
        $orderdata->batchId = $data->batchId;
        $orderdata->sellerid = $data->sellerid;

        // Save the order data
        $orderdata->save();

        // Return a JSON response with inserted order details and success message
        return response()->json([
            'success' => true,
            'message' => 'Order saved successfully',
            'data' => $orderdata  // include the saved order data in the response
        ], 200);
    }





    /**
     * GET /api/get_inventory?uid=8
     * Returns full inventory details filtered by uid
     */
    public function productjunctiondata(Request $request)
    {
        $request->validate([
            'uid' => 'nullable|integer|exists:userhierarchytabs,id',
            'rid' => 'nullable|integer',
        ]);

        $uid = $request->uid;
        $rid = $request->rid;

        // ✅ rid = roleid from userroletabs
        $roleColumnMap = [
            8 => 'pricecndf',
            9 => 'pricedistributor',
            10 => 'pricedealer',
            11 => 'pricesubdealer',
            12 => 'priceretialer',
        ];

        $query = \DB::table('productjunctions as pj')
            ->join('productadmintabs as p', 'p.id', '=', \DB::raw('CAST(pj.pid AS UNSIGNED)'))
            ->join('batch_product_prices as bpp', 'bpp.id', '=', \DB::raw('CAST(pj.batchid AS UNSIGNED)'))
            ->join('userhierarchytabs as u', 'u.id', '=', \DB::raw('CAST(pj.uid AS UNSIGNED)'))
            // ✅ pj.rid is a roleid — join directly to userroletabs
            ->leftJoin('userroletabs as rrt', 'rrt.id', '=', \DB::raw('CAST(pj.rid AS UNSIGNED)'))
            ->leftJoin('product_price_tables as ppt', function ($join) {
                $join->on('ppt.pid', '=', \DB::raw('CAST(pj.pid AS UNSIGNED)'))
                    ->whereColumn('ppt.state', 'u.state');
            })
            ->select(
                // --- Junction ---
                'pj.id as junction_id',
                'pj.uid',
                'pj.rid',
                'pj.pid',
                'pj.batchid',
                'pj.inventery as inventory_qty',

                // --- User (uid) ---
                'u.id as user_id',
                'u.username',
                'u.framname as user_framname',
                'u.roleid as user_roleid',
                'u.state',
                'u.city',

                // --- Rid Role (from userroletabs) ---
                'rrt.id as rid_role_id',        // ✅ e.g. 8
                'rrt.role as rid_role_name',    // ✅ e.g. "Cndf"

                // --- Product ---
                'p.id as product_id',
                'p.productname',
                'p.description',
                'p.category',
                'p.weightnum',
                'p.weihgtclass',
                'p.hsncode',
                'p.image',
                'p.measurement',

                // --- Batch ---
                'bpp.id as batch_id',
                'bpp.batchno',
                'bpp.boxqty',
                'bpp.pcsqty',
                'bpp.totalqty',
                'bpp.inventoryqty as batch_inventory_qty',

                // --- Price ---
                'ppt.id as price_id',
                'ppt.state as price_state',
                'ppt.pricecndf',
                'ppt.pricedistributor',
                'ppt.pricedealer',
                'ppt.pricesubdealer',
                'ppt.priceretialer'
            );

        if (!empty($uid)) {
            $query->where(\DB::raw('CAST(pj.uid AS UNSIGNED)'), $uid);
        }

        if (!empty($rid)) {
            $query->where(\DB::raw('CAST(pj.rid AS UNSIGNED)'), $rid);
        }

        $inventory = $query->get();

        if ($inventory->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => match (true) {
                    !empty($uid) && !empty($rid) => 'No inventory found for this user under given rid',
                    !empty($uid) => 'No inventory found for this user',
                    !empty($rid) => 'No inventory found under this rid',
                    default => 'No inventory records found',
                },
            ], 404);
        }

        $result = $inventory
            ->groupBy('user_id')
            ->map(function ($userItems) use ($roleColumnMap) {
                $userFirst = $userItems->first();

                $inventories = $userItems->map(function ($item) use ($roleColumnMap) {

                    // ✅ pj.rid IS the roleid — use it directly
                    $ridRoleId = (int) $item->rid;
                    $selectedColumn = $roleColumnMap[$ridRoleId] ?? null;

                    $priceObject = null;
                    if ($item->price_id) {
                        if ($selectedColumn) {
                            // ✅ Single price based on rid roleid
                            $priceObject = [
                                'price_id' => $item->price_id,
                                'state' => $item->price_state,
                                'productPrice' => $item->{$selectedColumn},
                            ];
                        } else {
                            // ✅ All prices if no match
                            $priceObject = [
                                'price_id' => $item->price_id,
                                'state' => $item->price_state,
                                'pricecndf' => $item->pricecndf,
                                'pricedistributor' => $item->pricedistributor,
                                'pricedealer' => $item->pricedealer,
                                'pricesubdealer' => $item->pricesubdealer,
                                'priceretialer' => $item->priceretialer,
                            ];
                        }
                    }

                    return [
                        'id' => $item->junction_id,
                        'pid' => $item->pid,
                        'batchid' => $item->batchid,
                        'priceid' => $item->price_id,
                        'uid' => $item->uid,
                        'rid' => $item->rid,
                        'inventery' => $item->inventory_qty,

                        'product' => [
                            'id' => $item->product_id,
                            'name' => $item->productname,
                            'description' => $item->description,
                            'category' => $item->category,
                            'weightnum' => $item->weightnum,
                            'weightclass' => $item->weihgtclass,
                            'hsncode' => $item->hsncode,
                            'image' => $item->image,
                            'measurement' => $item->measurement,

                            'batch' => [
                                'batch_id' => $item->batch_id,
                                'batchno' => $item->batchno,
                                'boxqty' => $item->boxqty,
                                'pcsqty' => $item->pcsqty,
                                'totalqty' => $item->totalqty,
                                'batch_inventory_qty' => $item->batch_inventory_qty,

                                // ✅ Price filtered by rid (roleid)
                                'price' => $priceObject,
                            ],
                        ],
                    ];
                })->values();

                return [
                    'user' => [
                        'user_id' => $userFirst->user_id,
                        'name' => $userFirst->username,
                        'role' => $userFirst->user_framname,
                        'roleid' => $userFirst->user_roleid,
                        'state' => $userFirst->state,
                        'city' => $userFirst->city,
                    ],

                    // ✅ rid_role from userroletabs
                    'rid_role' => $userFirst->rid_role_id ? [
                        'rid_role_id' => $userFirst->rid_role_id,
                        'rid_role_name' => $userFirst->rid_role_name,
                    ] : null,

                    'total_inventories' => $inventories->count(),
                    'inventories' => $inventories,
                ];
            })->values();

        return response()->json([
            'status' => true,
            'filtered_by_uid' => $uid ?? 'all',
            'filtered_by_rid' => $rid ?? 'all',
            'total_users' => $result->count(),
            'data' => $result,
        ]);
    }


    public function orderhistorydata()
    {
        $orderhistory = orderapprovedtable::get();

        if ($orderhistory->isNotEmpty()) {
            return response()->json([
                'order history List' => $orderhistory,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }

    public function productorderdata(Request $request)
    {
        $query = orderlisttab::latest();

        // Filter by userid if provided
        if ($request->has('userid') && !empty($request->userid)) {
            $query->where('userid', $request->userid);
        }

        $ordersec = $query->get();

        if ($ordersec->isNotEmpty()) {

            $ordersec = $ordersec->map(function ($order) {

                // ── User Details ──────────────────────────────────────────
                $user = DB::table('userhierarchytabs')
                    ->where('id', $order->userid)
                    ->select('id', 'username', 'contactno', 'email', 'address', 'region', 'tehsils', 'framname', 'roleid')
                    ->first();

                // ── Product Details ───────────────────────────────────────
                $pidArray = explode(',', $order->pid);
                $qtyArray = explode(',', $order->totalqty);
                $priceArray = explode(',', $order->price);
                $totalArray = explode(',', $order->totalPrice);
                $statusArray = explode(',', $order->orderstatus);
                $qtyMsrArray = explode(',', $order->qtymasurment);
                $productBulkArray = explode(',', $order->productbulk);
                $priceIdArray = explode(',', $order->priceId);
                $batchIdArray = explode(',', $order->batchId);

                $products = collect($pidArray)->map(function ($pid, $index) use ($qtyArray, $priceArray, $totalArray, $statusArray, $qtyMsrArray, $productBulkArray, $priceIdArray, $batchIdArray) {
                    $product = DB::table('productadmintabs')
                        ->where('id', trim($pid))
                        ->first();

                    return [
                        'pid' => trim($pid),
                        'productname' => $product->productname ?? null,
                        'description' => $product->description ?? null,
                        'category' => $product->category ?? null,
                        'categoryid' => $product->categoryid ?? null,
                        'brand' => $product->brand ?? null,
                        'brandid' => $product->brandid ?? null,
                        'image' => $product->image ?? null,
                        'file' => $product->file ?? null,
                        'mrp' => $product->mrp ?? null,
                        'dp' => $product->dp ?? null,
                        'mop' => $product->mop ?? null,
                        'hsncode' => $product->hsncode ?? null,
                        'vehicle' => $product->vehicle ?? null,
                        'measurement' => $product->measurement ?? null,
                        'weightnum' => $product->weightnum ?? null,
                        'weihgtclass' => $product->weihgtclass ?? null,
                        'quantity' => $product->quantity ?? null,
                        'boxquantity' => $product->boxquantity ?? null,
                        // Order-level per product fields
                        'ordered_qty' => $qtyArray[$index] ?? null,
                        'qtymasurment' => $qtyMsrArray[$index] ?? null,
                        'productbulk' => $productBulkArray[$index] ?? null,
                        'price' => $priceArray[$index] ?? null,
                        'totalPrice' => $totalArray[$index] ?? null,
                        'priceId' => $priceIdArray[$index] ?? null,
                        'batchId' => $batchIdArray[$index] ?? null,
                        'orderstatus' => $statusArray[$index] ?? null,
                    ];
                });

                // Calculate total order price sum
                $grandTotalSum = array_sum(explode(',', $order->totalPrice));

                // ── Final Response Structure ──────────────────────────────
                return [
                    // 1. Complete Order Details
                    'order_id' => $order->id,
                    'userid' => $order->userid,
                    'orderstatus' => $order->orderstatus,
                    'productbulk' => $order->productbulk,
                    'pid' => $order->pid,
                    'qtymasurment' => $order->qtymasurment,
                    'totalqty' => $order->totalqty,
                    'price' => $order->price,
                    'totalPrice' => $order->totalPrice,
                    'grandTotal' => $order->grandTotal,
                    'totalorderprice' => $grandTotalSum,   // e.g. 1000 + 3000 = 4000
                    'priceId' => $order->priceId,
                    'batchId' => $order->batchId,
                    'sellerid' => $order->sellerid,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,

                    // 2. User Details
                    'user_details' => $user,

                    // 3. Product Details
                    'product_details' => $products,
                ];
            });

            return response()->json([
                'Status' => 'Success',
                'order List' => $ordersec,
            ], 200);

        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }


}