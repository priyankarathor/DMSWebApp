<?php
use App\Livewire\Adminorderproduct;
use App\Livewire\Adminorderlisttouser;
use App\Livewire\Adminorderhistory;
use App\Livewire\Allhierarchydata;
use App\Livewire\Allusersform;
use App\Livewire\Authdealertable;
use App\Livewire\Categoryadmin;
use App\Livewire\Dealerlist;
use App\Livewire\Demoform;
use App\Livewire\Demoformedit;
use App\Livewire\Disproduct;
use App\Livewire\Disstocklist;
use App\Livewire\Distributerinvoice;
use App\Livewire\Distributerlist;
use App\Livewire\Distributerorderlist;
use App\Livewire\Distributorpage;

use App\Livewire\Dstributereditlist;
use App\Livewire\Edituserdata;
use App\Livewire\Employeelist;
use App\Livewire\Getorders;
use App\Livewire\Index;
use App\Livewire\Invoicedata;
use App\Livewire\Invoicedataedit;
use App\Livewire\Invoiceform;
use App\Livewire\Invoiceviewtable;
use App\Livewire\Manageaccount;
use App\Livewire\Myproducthistory;
use App\Livewire\Myproductinventery;
use App\Livewire\Orderapprove;
use App\Livewire\Orderapproveuser;
use App\Livewire\Orderhistory;
use App\Livewire\Orderproduct;
use App\Livewire\Producteditpage;
use App\Livewire\Productpage;
use App\Livewire\Productpagelist;
use App\Livewire\Retailerlist;
use App\Livewire\Retailerlistpage;
use App\Livewire\Retailerpage;
use App\Livewire\Subcategory;
use App\Livewire\Subdealerlist;
use App\Livewire\Userdiscount;
use App\Livewire\Userdiscountedit;
use App\Livewire\Usermultiauthlist;
use App\Livewire\Userorderrole;
use App\Livewire\Userprofile;
use App\Livewire\Mangeaccountedit;
use App\Livewire\Userstocklist;
use App\Livewire\Userrolepage;
use App\Livewire\Userroleedit;
use App\Models\manageaccounttable;
use App\Livewire\Editmastercategory;
use App\Livewire\Editsubcategory;
use App\Livewire\Quotation;
use App\Livewire\InvoiceTable;
use App\Livewire\Invoicedetailsget;
use App\Models\subdealertable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCsvController;

use App\Livewire\Stockholder;
use App\Livewire\Productdetails;

use App\Livewire\Rolehierarchy;

use App\Livewire\Companypermission;
use App\Livewire\Managepermission;

use App\Livewire\Roledistributiion;
use App\Livewire\ProductCsvImport;
use App\Livewire\Todaysell;
use App\Livewire\Trackingbystate;
use App\Livewire\BatchRoleTracking;
use App\Livewire\Brandadd;
use App\Livewire\Userstockdetails;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', Index::class)->name('index');
    Route::get('/product', Productpage::class)->name('product');
    Route::post('/productinsert', [Productpage::class, 'productdata'])->name('productinsert');
    Route::get('/productlist', Productpagelist::class)->name('productlist');

    Route::get('/productDetails/{id}', Productdetails::class)->name('productDetails');

    Route::post('/viewstatus', [Productpagelist::class, 'status']);

    Route::get('/distributor', Distributorpage::class)->name('distributor');

    Route::post('/distrinuterinsert', [Distributorpage::class, 'distributerdata'])->name('distrinuterinsert');

    // role hairarchy details

    Route::get('/distributorhierarchy', Roledistributiion::class)->name('distributorhierarchy');

    Route::post('/distrinuterinserthierarchy', [Roledistributiion::class, 'distributerdatainsert'])->name('distrinuterinserthierarchy');

    // role hairarchy details

    Route::get('/distributorlist', Distributerlist::class)->name('distributorlist');

    Route::get('/retailerpage', Retailerpage::class)->name('retailerpage');
    Route::post('/retailerinsert', [Retailerpage::class, 'retailerdata'])->name('retailerinsert');
    Route::get('/retailerlist', Retailerlistpage::class)->name('retailerlist');
    Route::get('/disproduct', Disproduct::class)->name('disproduct');
    Route::post('/insertproduct', [Disproduct::class, 'distributerdata'])->name('insertproduct');

    Route::get('/orderlist', Distributerorderlist::class)->name('orderlist');

    Route::get('/stockorderlist/{id?}', Userstocklist::class)->name('stockorderlist');

    Route::get('/distributerorder/{id}', Orderapprove::class)->name('distributerorder');

    Route::get('/deletedataall/{id}', [Orderapprove::class, 'deletedata'])->name('deletedataall');

    Route::post('/insertorder/{id}', [Orderapprove::class, 'insertdistributerdata'])->name('insertorder');
    Route::get('/distributerinvoicedata', Distributerinvoice::class)->name('distributerinvoicedata');
    Route::get('/Quotationinvoicedata', Quotation::class)->name('Quotationinvoicedata');
    Route::get('/allproductlist', Productpagelist::class)->name('allproductlist');


    Route::get('/categorydata', Categoryadmin::class)->name('categorydata');
    Route::get('/categorydelete/delete/{id}', [Categoryadmin::class, 'categorydelete']);

    Route::post('/categoryinsert', [Categoryadmin::class, 'insertdata'])->name('categoryinsert');
    Route::get('/subcategorydata', Subcategory::class)->name('subcategorydata');

    Route::get('/subcategorydelete/delete/{id}', [Subcategory::class, 'deletesubcategory']);

    Route::post('/subcategoryinsert', [Subcategory::class, 'subinsertdata'])->name('subcategoryinsert');

    Route::get('/distributerstock', Disstocklist::class)->name('distributerstock');
    Route::get('/alluser', Allusersform::class)->name('alluser');
    Route::post('/insertuserdata', [Allusersform::class, 'insertdata'])->name('insertuserdata');
    Route::post('/viewstatus', [Productpagelist::class, 'status'])->name('viewstatus');
    Route::get('/delproduct/{id}', [Productpagelist::class, 'deleteproduct'])->name('delproduct');

    Route::get('/manageaccount', Manageaccount::class)->name('manageaccount');
    Route::post('/insertaccdata', [Manageaccount::class, 'managedata'])->name('insertaccdata');
    Route::get('/manageaccountdata/{id}', Mangeaccountedit::class)->name('manageaccountdata');
    Route::post('/manageaccountedit/{id}', [Mangeaccountedit::class, 'editaccountdata'])->name('manageaccountedit');


    // campany details 
    Route::get('/manageaccountlist/{id}', Managepermission::class)->name('manageaccountlist');
    Route::post('/insertaccdatalist', [Managepermission::class, 'managedatalist'])->name('insertaccdatalist');
    Route::get('/manageaccountdatalist/{id}', Managepermission::class)->name('manageaccountdatalist');
    Route::post('/manageaccounteditlist/{id}', [Managepermission::class, 'manageaccounteditlist'])->name('manageaccountedit');
    // campany details


    Route::get('/demo', Demoform::class)->name('demo');
    Route::post('/demoinsert', [Demoform::class, 'insertalldata'])->name('demoinsert');
    Route::get('/deletedemo/{id}', [Demoform::class, 'demodelete'])->name('deletedemo');
    Route::get('/demoedit/{id}', Demoformedit::class)->name('demoedit');
    Route::post('/deletedemoedit/{id}', [Demoformedit::class, 'demoformdataedit'])->name('deletedemoedit');
    Route::get('/allhierarchydata/{id}', Allhierarchydata::class)->name('allhierarchydata');

    Route::get('/deletedata/{id}', [Distributerlist::class, 'deleteinputdata'])->name('deletedata');
    Route::get('/alltabledataget/{id}', Dstributereditlist::class)->name('alltabledataget');
    Route::post('/distributeredit/{id}', [Dstributereditlist::class, 'distributinputdataedit'])->name('distributeredit');


    Route::get('/productedit/{id}', Producteditpage::class)->name('productedit');
    Route::post('/productdataedit/{id}', [Producteditpage::class, 'editproductdata'])->name('productdataedit');

    Route::get('/insertdataget', Invoiceform::class)->name('insertdataget');
    Route::post('/insertdata', [Invoiceform::class, 'uploadinvoice'])->name('insertdata');
    Route::get('/orderproduct/{id}', Orderproduct::class)->name('orderproduct');

    Route::post('/adminStatus', [Orderproduct::class, 'adminStatus'])->name('admin.status');
    // Route::get('/dealerlist',Dealerlist::class)->name('dealerlist');
// Route::get('/subdealerlist',Subdealerlist::class)->name('subdealerlist');
// Route::get('/retailerlist',Retailerlist::class)->name('retailerlist');
// Route::get('/employeelist',Employeelist::class)->name('employeelist');
    Route::get('/authdealer', Authdealertable::class)->name('authdealer');
    Route::get('/invoicedata', Invoicedata::class)->name('invoicedata');
    Route::get('/invoicedatatable', Invoiceviewtable::class)->name('invoicedatatable');

    //quotation Invoice
    Route::get('/quotationinvoicetable', InvoiceTable::class)->name('quotationinvoicetable');
    Route::get('/onlineinvoicedelete/{id}', [InvoiceTable::class, 'deleteonlineinvoicedata'])->name('onlineinvoicedelete');

    Route::get('/onlineinvoiceget/{id}', Invoicedetailsget::class)->name('onlineinvoiceget');

    Route::get('/invoicedataeditpage/{id}', Invoicedataedit::class)->name('invoicedataeditpage');
    Route::post('/invoicedataedit/{id}', Invoicedataedit::class, 'invoiceeditdata')->name('invoicedataedit');

    Route::get('/deleteinvoice/{id}', [Invoiceviewtable::class, 'deleteinvoicedata'])->name('deleteinvoice');

    Route::get('/invoiceget/{id}', Invoicedata::class)->name('invoiceget');

    Route::post('/update-status/{id}', [Orderproduct::class, 'updateStatus']);
    Route::post('/orderstatus/{id}', [Orderproduct::class, 'orderupload'])->name('orderstatus');

    Route::get('/edituserdata/{id}', Edituserdata::class)->name('edituserdata');
    Route::post('/editdistributer/{id}', [Edituserdata::class, 'edituser'])->name('editdistributer');
    Route::get('/usermultiauth', Usermultiauthlist::class)->name('usermultiauth');
    Route::get('/userprofiledata/{id}', Userprofile::class)->name('userprofiledata');
    Route::get('/role', Userrolepage::class)->name('role');
    Route::post('/roledata', [Userrolepage::class, 'roledefine'])->name('roledata');
    Route::get('/roledel/{id}', [Userrolepage::class, 'deletedata'])->name('roledel');

    Route::get('/userdiscount', Userdiscount::class)->name('userdiscount');
    Route::post('/discountdata', [Userdiscount::class, 'discount'])->name('discountdata');
    Route::get('/discountdel/{id}', [Userdiscount::class, 'deletediscountdata'])->name('discountdel');

    Route::get('/userdiscountdata/{id}', Userdiscountedit::class)->name('userdiscountdata');
    Route::post('/discountedit/{id}', [Userdiscountedit::class, 'discountdataedit'])->name('discountedit');

    // brandadd add 

    Route::get('/userbrand', Brandadd::class)->name('userbrand');
    Route::post('/userbranddata', [Brandadd::class, 'branddata'])->name('userbranddata');
    Route::get('/userbranddelete/{id}', [Brandadd::class, 'deletediscountdata'])->name('userbranddelete');

    Route::get('/userbranddataedit/{id}', Brandadd::class)->name('userbranddataedit');
    Route::post('/branndedit/{id}', [Brandadd::class, 'branddataedit'])->name('branndedit');

    //end brand add

    Route::get('/productinventery', Myproductinventery::class)->name('productinventery');

    Route::get('/userorder', Userorderrole::class)->name('userorder');

    Route::get('/getuserorder', Getorders::class)->name('getuserorder');

    Route::get('/productapprove/{id}', Orderapproveuser::class)->name('productapprove');
    Route::get('/history', Orderhistory::class)->name('history');

    Route::get('/approveorders', Adminorderhistory::class)->name('approveorders');

    Route::get('/userproducthistory', Myproducthistory::class)->name('userproducthistory');

    Route::get('/deletedata/{id}', [Manageaccount::class, 'deleteuserdata'])->name('deletedata');


    Route::get('/roleedit/{id}', Userroleedit::class)->name('roleedit');
    Route::post('/roledataedite/{id}', [Userroleedit::class, 'roledefineedit'])->name('roledataedite');

    Route::get('/orderproductadmin/{id}', Adminorderproduct::class)->name('orderproductadmin');

    Route::post('/adminStatusadmin', [Adminorderproduct::class, 'adminStatus'])->name('admin.status');
    Route::post('/update-statusadmin/{id}', [Adminorderproduct::class, 'updateStatus']);

    Route::get('/orderlistadmin', Adminorderlisttouser::class)->name('orderlistadmin');

    Route::get('/editmastercate/{id}', Editmastercategory::class)->name('editmastercate');
    Route::post('/editmastercategorydata/{id}', [Editmastercategory::class, 'editmastercategorydata'])->name('editmastercategorydata');

    Route::get('/editsubmaster/{id}', Editsubcategory::class)->name('editsubmaster');
    Route::post('/editsubcategorydata/{id}', [Editsubcategory::class, 'editsubcategorydatas'])->name('editsubcategorydata');

    Route::get('/product-import', ProductCsvImport::class)->name('product-import');

    Route::get('/rolehierarchylist', Rolehierarchy::class)->name('rolehierarchylist');

    Route::get('/permissionlist', Companypermission::class)->name('permissionlist');

    Route::get('/batchtracking/{id}', Trackingbystate::class)->name('batchtracking');

    Route::get('/BatchRole/{id}', BatchRoleTracking::class)->name('BatchRole');

    Route::get('/user-stock-details/{id}', Userstockdetails::class)->name('user.stock.details');
    Route::get('/Stockholder/{sellerid}', Stockholder::class)->name('stockholder');
    Route::get('/todaysell', Todaysell::class)->name('todaysell');
});