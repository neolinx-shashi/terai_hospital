<div class="panel panel-default department-add">

    <div class="panel-body">
        <form method="post" action="{{url('update-doctor-charge',array($edit->id))}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Title <label class="text-danger">*</label></label>

                <input type="text" name="title" placeholder="Enter a Title" value="{{ $edit->title }}"
                       class="form-control" id="title">
                @if ($errors->has('title'))
                    <span class="help-block" style="color: red">
                <strong>  {{ $errors->first('title') }}</strong>
            </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('charge') ? ' has-error' : '' }}">
                <label for="charge">Charge <label class="text-danger">*</label></label>

                <input type="text" name="charge" placeholder="Enter Doctor Charge" value="{{ $edit->charge }}"
                       class="form-control" id="charge">
                @if ($errors->has('charge'))
                    <span class="help-block" style="color: red">
                    <strong>  {{ $errors->first('charge') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i> Update</button>

            <a href="{{url('doctor-charge')}}">
                <button type="button" class="btn btn-primary save btn-flat pull-right"><i class="fa fa-plus-circle"></i>
                    Add New
                </button>
            </a>
            <label class="note" for="panel-body">Note: Field With <span class="text-danger"> * </span> are mandatory
            </label>
        </form>
    </div>
</div>
