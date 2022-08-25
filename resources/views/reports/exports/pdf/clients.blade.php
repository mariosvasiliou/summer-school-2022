@extends('layouts.simple')

@section('content')
    <div class="container-fluid">
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-light">
            <tr>
                <th>{{__('Full Name')}}</th>
                <th>{{__('Email')}}</th>
                <th>{{__('Street')}}</th>
                <th>{{__('Building')}}</th>
                <th>{{__('Number')}}</th>
                <th>{{__('City')}}</th>
                <th>{{__('Country')}}</th>
                <th>{{__('Work Number')}}</th>
                <th>{{__('Home Number')}}</th>
                <th>{{__('Mobile Number')}}</th>
                <th>{{__('Comments')}}</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->full_name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->street }}</td>
                    <td>{{ $client->building }}</td>
                    <td>{{ $client->number }}</td>
                    <td>{{ $client->city }}</td>
                    <td>{{ $client->country }}</td>
                    <th>{{ $client->work_number }}</th>
                    <th>{{ $client->home_number }}</th>
                    <th>{{ $client->mobile_number }}</th>
                    <th>{{ $client->comments }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
