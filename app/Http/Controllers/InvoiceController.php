<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices=Invoice::where([])->get();
        return view('viewbills', [
            'invoices' => $invoices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $invoice = new Invoice();
        $invoiceID = $invoice->id=Str::uuid();
        $invoice->customer_email=$request->customer_email;
        $invoice->bill_total=0;
        $invoice->amount_collected=( $request->collected_500 * 500 ) +
        ( $request->collected_200 * 200 ) +
        ( $request->collected_100 * 100 ) +
        ( $request->collected_50 * 50 ) +
        ( $request->collected_20 * 20 ) +
        ( $request->collected_10 * 10 );
        $invoice->collected_500=$request->collected_500;
        $invoice->collected_200=$request->collected_200;
        $invoice->collected_100=$request->collected_100;
        $invoice->collected_50=$request->collected_50;
        $invoice->collected_20=$request->collected_20;
        $invoice->collected_10=$request->collected_10;
        $invoice->save();
        $billTotal = 0;
        foreach($request->product_id as $index=>$pID)
        {
            $pData=Product::where(["product_id"=>$pID])->first();
            $taxAmt =sprintf( "%.2f",
            $pData->price * $request->quantity[$index]
            * $pData->tax / 100 );
            $netAmt = $pData->price * $request->quantity[$index];
            $grossAmt = $taxAmt + $netAmt;

            $invoiceDetails = new InvoiceDetail();
            $invoiceDetails->quantity = $request->quantity[$index];
            $invoiceDetails->product_id = $pID;
            $invoiceDetails->invoice_id = $invoiceID;
            $invoiceDetails->per_pc_price = $pData->price;
            $invoiceDetails->tax_perc = $pData->tax;
            $invoiceDetails->tax_amount = $taxAmt;
            $invoiceDetails->net_amount = $netAmt;
            $invoiceDetails->net_amount_inc_tax = $grossAmt;
            $invoiceDetails->save();
            $billTotal += $grossAmt;
        }
        $iData=Invoice::where(["id"=>$invoiceID])->first();
        $iData->bill_total = $billTotal;
        $iData->save();

        return redirect('/bills');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($invoiceID)
    {
        //
        $invoice=Invoice::where(['id'=>$invoiceID])->first();
        $invoiceDetails=InvoiceDetail::where(['invoice_id'=>$invoiceID])->get();
        return view('viewbill', [
            'invoice' => $invoice,
            'invoiceDetails' => $invoiceDetails
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
