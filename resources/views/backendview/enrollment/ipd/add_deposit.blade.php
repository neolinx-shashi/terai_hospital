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
                    <li><a href="{{URL('ip-enrollment/patients')}}">In Patient List</a></li>
                    <li class="active">Add Deposit</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <form method="post"
                              action="{{URL('ip-enrollment/ipatient/'.$id.'/store-deposit')}}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group {{ $errors->has('deposit') ? ' has-error' : '' }}">
                                <label for="deposit">Deposit Amount <label class="text-danger">*</label></label>

                                <input type="text" name="deposit" placeholder="Enter Deposit Amount"
                                       value="{{ old('deposit') }}"
                                       class="form-control" id="deposit">
                                @if ($errors->has('deposit'))
                                    <span class="help-block" style="color: red">
                                    <strong>  {{ $errors->first('deposit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>

                            <button type="submit" class="btn btn-primary save btn-flat"><i
                                        class="fa fa-plus-circle"></i>Add
                            </button>

                            <label class="note" for="panel-body">Note: Field With <span class="text-danger"> * </span>
                                are mandatory
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
