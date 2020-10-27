@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('MONTHLY BCP REPORTING CHECKLIST List') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('MONTHLY BCP REPORTING CHECKLIST List') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="card-title text-right">
                                @can("create-bcp")
                                    @if($bcp)
                                <a href="{{route("checklist.monthly-checklist")}}" class="btn btn-primary"> <i class="fa fa-plus"></i> Add New</a>
                                    @endif
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="verification-table">
                                    <thead>
                                    <tr>
                                        <th>Wsp</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script defer>
        $(function () {
            $('#verification-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('checklist.list') !!}',
                columns: [
                    {data: 'wsp', name: 'wsp'},
                    {data: 'checklist_month', name: 'checklist_month'},
                    {data: 'year', name: 'year'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
