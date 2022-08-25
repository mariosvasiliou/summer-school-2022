@extends('layouts.app')
@section('content')
    <div class="container px-5">
        <h1 class="text-center">{{__('Create User')}}</h1>
        <hr />
        @include('forms.user',['url'=>route('users.store'),'contact'=>null])
    </div>
@stop
