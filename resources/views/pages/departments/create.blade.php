@extends('layouts.app')
@section('content')
    <div class="container px-5">
        <h1 class="text-center">{{__('Create Department')}}</h1>
        <hr />
        @include('forms.department',['url'=>route('departments.store'),'department'=>null])
    </div>
@stop
