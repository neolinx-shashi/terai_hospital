@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="error-section" style="padding: 27% 0; text-align: center; color: darkgray;">
            <div class="error-template">
                <h1 style="color:orange">
                    Oops!</h1>
                <h2>
                    Sorry The page You are looking could not be found  ।</h2>
                <div class="error-details">
                    Sorry, an error has occured, Requested page not found!
                </div>

                    <a href="{{url('/')}}" class="btn btn-primary btn-lg" style="margin-top: 30px; margin-bottom: 40px;
                     padding: 10px 20px;
                     background-color: darkblue">
                        <span class="glyphicon glyphicon-home"></span>
                           Take Me Home </a>
            </div>
        </div>
    </div>
@stop