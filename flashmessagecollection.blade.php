@section('flashmessage')
    @if(Session::has('error'))
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sorry!</strong> {{ Session::get('error') }}
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Well Done! </strong>
            {{ Session::get('success') }}
        </div>
    @endif

 @if (Session::has('foreignerror'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong> </strong>
            {{ Session::get('foreignerror') }}
        </div>
    @endif
   
@stop