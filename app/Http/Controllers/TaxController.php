<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;

class TaxController extends Controller
{
    public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'doc_no' => 'required',
            'doc_date' => 'required',
            'tax_start_date' => 'required',
            'tax_renewal_date' => 'required',
            'tax_receipt_no' => 'required',
            'tax_charge' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        } else {
            return [
                'success' => 1,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        }
    }

    public function index ()
    {
        $taxes = Tax::with('vehicle')
                        ->orderBy('tax_start_date', 'DESC')
                        ->paginate(10);

        return view('taxes.list', [
            'taxes' => $taxes,
        ]);
    }

    public function create ()
    {
        return view('taxes.newform', [

        ]);    	
    }

    public function store (Request $req)
    {
        // Upload attach file
        $filename = '';
        if ($file = $req->file('attachfile')) {
            $filename = $file->getClientOriginalName();
            $file->move('uploads', $filename);
        }

    	$newTax = new Tax();
        $newTax->doc_no = $req['doc_no'];
        $newTax->doc_date = $req['doc_date'];
        $newTax->vehicle_id = $req['vehicle_id'];
        $newTax->tax_start_date = $req['tax_start_date'];
        $newTax->tax_renewal_date = $req['tax_renewal_date'];
        $newTax->tax_receipt_no = $req['tax_receipt_no'];
        $newTax->tax_charge = $req['tax_charge'];
        $newTax->remark = $req['remark'];
        $newTax->attachfile = $req['attachfile'];
        $newTax->status = '1'; //

        if ($newTax->save()) {
            return redirect('tax/list');
        }
    }

    public function edit ()
    {
    	return view('insurances.editform', [

        ]);
    }

    public function update (Request $req)
    {
        // Upload attach file
        $filename = '';
        if ($file = $req->file('attachfile')) {
            $filename = $file->getClientOriginalName();
            $file->move('uploads', $filename);
        }

    	$tax = Tax::find($req['id'])->first();
        $tax->doc_no = $req['doc_no'];
        $tax->doc_date = $req['doc_date'];
        $tax->vehicle_id = $req['vehicle_id'];
        $tax->tax_start_date = $req['tax_start_date'];
        $tax->tax_renewal_date = $req['tax_renewal_date'];
        $tax->tax_receipt_no = $req['tax_receipt_no'];
        $tax->tax_charge = $req['tax_charge'];
        $tax->remark = $req['remark'];
        $tax->attachfile = $req['attachfile'];

        if ($tax->save()) {
            return redirect('tax/list');
        }
    }

    public function delete ()
    {
    	
    }
}
