@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-bordered table-striped bg-white">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Description')}}</th>
                    <th scope="col">{{__('Export')}}</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($reports as $report)
                    <tr>
                        <th>{{$report->id}}</th>
                        <th>{{$report->name}}</th>
                        <th>{{\Str::limit($report->description,200)}}</th>
                        <th>
                            @can('view',$report)
                                <a class="btn btn-sm btn-outline-danger" href="{{route('reports.pdf',['report'=>$report->id])}}"
                                   title="Export to PDF" data-bs-toggle="tooltip">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-success" href="{{route('reports.excel',['report'=>$report->id])}}"
                                   title="Export to Excel" data-bs-toggle="tooltip">
                                    <i class="bi bi-filetype-xlsx"></i>
                                </a>
                            @endcan
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $reports->links() }}
        </div>
    </div>
@stop

