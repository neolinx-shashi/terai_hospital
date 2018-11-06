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
                <li>Manage Discount Type</li>
               
            </ol>
        </div>
    </div>   
</div>

<section class="content">
	{{ Session::get('status') }}

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">List Discount Types</div>
			<div class="panel-body">
		    	<table class="table table-striped">
		    		<thead>
		    			<tr>
		    				<th>S.No.</th>
		    				<th>Title</th>
		    				<th>Actions</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    			@if ($type_list)
		    			@foreach ($type_list as $key => $val)
		    			<tr>
		    				<td>{{ $key + 1 }}</td>
		    				<td>{{ $val->d_type }}</td>
		    				<td><a href="{{ url('discount-type/'.$val->d_id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a></td>
		    			</tr>
		    			@endforeach
		    			@endif
		    		</tbody>
		    	</table>
		    	<span class="pull-right">{{ $type_list->links() }}</span>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">{{ $action }} Discount Type</div>
			<div class="panel-body">
		    	<form action="{{ $url }}" method="post" onsubmit="return validate()">
		    		{{ csrf_field() }}
		    		@if ($action == 'Edit')
	                {{ method_field('PATCH') }}
	                @endif
		    		
		    		<div class="form-group">
		    			<label for="discount">Discount Type</label>
		    			<input name="d_type" id="d_type" class="form-control" placeholder="Discount Type" value="{{{ $detail->d_type or '' }}}" />
		    			<div class="err type-err"></div>
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
	var type = $('#d_type').val();

	if (type === '') {
		$('.type-err').text('This field can not be empty.');
		return false;
	} else {
		$('.type-err').text('');
	}
}
</script>

@endsection