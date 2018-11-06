<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountType;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function index() {
    	$discount = Discount::leftJoin('categories', 'discount.cat_id', '=', 'categories.id')->leftJoin('discount_type', 'discount.dis_type', '=', 'discount_type.d_id')->select('discount.*', 'categories.title', 'discount_type.d_type')->orderBy('categories.title', 'asc')->paginate(20);
    	$categories = Category::where('level', '1')->orderBy('title', 'asc')->get();
    	$discount_type = DiscountType::orderBy('d_type', 'asc')->get();
    	$url = url('/discount');
    	$action = 'Add';

    	return view('backendview.discount.list', compact('discount', 'categories', 'discount_type', 'url', 'action'));
    }

    public function store(Request $request) {
    	$input = $request->all();
    	$insert = Discount::create($input);

    	if ($insert)
    		$status = 'Data Saved Sucessfully.';
    	else
    		$status = 'Data Saving Failed.';

    	$request->session()->flash('status', $status);

    	return redirect('/discount');
    }

    public function edit($id, Request $request) {
    	$discount = Discount::leftJoin('categories', 'discount.cat_id', '=', 'categories.id')->leftJoin('discount_type', 'discount.dis_type', '=', 'discount_type.d_id')->select('discount.*', 'categories.title', 'discount_type.d_type')->orderBy('categories.title', 'asc')->paginate(20);
    	$categories = Category::where('level', '1')->orderBy('title', 'asc')->get();
    	$discount_type = DiscountType::orderBy('d_type', 'asc')->get();
    	$url = url('/discount/'.$id);
    	$action = 'Edit';
    	$detail = Discount::find($id);

    	return view('backendview.discount.list', compact('detail', 'discount', 'categories', 'discount_type', 'url', 'action'));
    }

    public function update($id, Request $request) {
    	$input = $request->all();

    	$data = Discount::find($id);
    	$update = $data->fill($input)->save();

    	if ($update)
    		$status = 'Data Updated Sucessfully.';
    	else
    		$status = 'Data Update Failed.';

    	$request->session()->flash('status', $status);

    	return redirect('/discount');
    }
}
