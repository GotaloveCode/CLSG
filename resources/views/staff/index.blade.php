@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Staff List') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/home")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Staff List') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content-body">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="staff-list">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Type</th>
                                <th>WSP</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script>
        $(function () {
            $('#staff-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('staff.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'position', name: 'position'},
                    {data: 'type', name: 'type'},
                    {data: 'wsp.name', name: 'wsp.name', searchable: true},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
