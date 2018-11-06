<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiscountType;

class DiscountTypeController extends Controller
{
    public function index() {
    	$type_list = DiscountType::orderBy('d_type', 'asc')->paginate(20);
    	$url = url('/discount-type');
    	$action = 'Add';

    	return view('backendview.discount.type', compact('type_list', 'url', 'action'));
    }

    public function store(Request $request) {
    	$input = $request->all();

    	$insert = DiscountType::create($input);

    	if ($insert)
    		$status = 'Data Saved Sucessfully.';
    	else
    		$status = 'Data Saving Failed.';

    	$request->session()->flash('status', $status);

    	return redirect('/discount-type');
    }

    public function edit($id, Request $request) {
    	$type_list = DiscountType::orderBy('d_type', 'asc')->paginate(20);
    	$url = url('/discount-type/'.$id);
    	$action = 'Edit';
    	$detail = DiscountType::find($id);

    	return view('backendview.discount.type', compact('type_list', 'detail', 'url', 'action'));
    }

    public function update($id, Request $request) {
    	$input = $request->all();

    	$data = DiscountType::find($id);
    	$update = $data->fill($input)->save();

    	if ($update)
    		$status = 'Data Updated Sucessfully.';
    	else
    		$status = 'Data Update Failed.';

    	$request->session()->flash('status', $status);

    	return redirect('/discount-type');
    }
}
