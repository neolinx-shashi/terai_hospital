@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
@extends('backendlayout.flashmessagecollection')

<div class="search-breadcrumb-only">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li>Manage Discount</li>
               
            </ol>
        </div>
    </div>   
</div>

<section class="content">
	<div class="col-md-12">{{ Session::get('status') }}</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">List Discounts</div>
			<div class="panel-body">
		    	<table class="table table-striped">
		    		<thead>
		    			<tr>
		    				<th>S.No.</th>
		    				<th>Title</th>
		    				<th>Discount Type</th>
		    				<th>Discount %</th>
		    				<th>Actions</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    			@if ($discount)
		    			@foreach ($discount as $key => $val)
		    			<tr>
		    				<td>{{ $key + 1 }}</td>
		    				<td>{{ $val->title }}</td>
		    				<td>{{ $val->d_type }}</td>
		    				<td>{{ $val->dis_percent }}</td>
		    				<td><a href="{{ url('discount/'.$val->dis_id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a></td>
		    			</tr>
		    			@endforeach
		    			@endif
		    		</tbody>
		    	</table>
		    	<span class="pull-right">{{ $discount->links() }}</span>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">{{ $action }} Discount</div>
			<div class="panel-body">
		    	<form action="{{ $url }}" method="post" onsubmit="return validate()">
		    		{{ csrf_field() }}
		    		@if ($action == 'Edit')
	                {{ method_field('PATCH') }}
	                @endif
		    		<div class="form-group">
		    			<label for="category">Category</label>
		    			<select name="cat_id" id="cat_id" class="form-control">
		    				<option value="0">- Choose Category -</option>
		    				@foreach ($categories as $cat)
		    				<option value="{{ $cat->id }}" @if ($action == 'Edit' && $cat->id == $detail->cat_id) selected @endif>{{ $cat->title }}</option>
		    				@endforeach
		    			</select>
		    			<div class="err cat-err"></div>
		    		</div>

		    		<div class="form-group">
		    			<label for="discount type">Discount Type</label>
		    			<select class="form-control" name="dis_type" id="dis_type">
		    				<option value="0">- Choose Discount Type -</option>
		    				@foreach ($discount_type as $type)
		    				<option value="{{ $type->d_id }}" @if ($action == 'Edit' && $type->d_id == $detail->dis_type) selected @endif>{{ $type->d_type }}</option>
		    				@endforeach
		    			</select>
		    			<div class="err type-err"></div>
		    		</div>

		    		<div class="form-group">
		    			<label for="discount">Discount %</label>
		    			<input name="dis_percent" id="dis_percent" class="form-control" placeholder="%" value="{{{ $detail->dis_percent or '' }}}" />
		    			<div class="err dis-err"></div>
		    		</div>

		    		<div class="form-group">
		    			<input name="submit" type="submit" class="btn btn-info" value="Save" />
		    		</div>
		    	</form>
			</div>
		</div>
	</div>

</section>

<script>
function validate() {
	var category = $('#cat_id').val();
	var type = $('#dis_type').val();
	var discount = $('#dis_percent').val();

	if (category == 0) {
		$('.cat-err').text('This field can not be empty.');
		return false;
	} else {
		$('.cat-err').text('');
	}

	if (type == 0) {
		$('.type-err').text('This field can not be empty.');
		return false;
	} else {
		$('.type-err').text('');
	}

	if (discount == '') {
		$('.dis-err').text('This field can not be empty.');
		return false;
	} else {
		$('.dis-err').text('');
	}

}
</script>

@endsection