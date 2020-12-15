@extends('layouts.dashboard')
@push('css')
<link rel="stylesheet" type="text/css"
      href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('My Emergency Response Plans List') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('My Emergency Response Plans List') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="erps-table">
                                <thead>
                                <tr>
                                    <th>Wsp</th>
                                    <th>Period</th>
                                    <th>ERP Coordinator</th>
                                    <th>Status</th>
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
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script defer>
        $(function () {
            $('#erps-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('erps.reviewer-list') !!}',
                columns: [
                    {data: 'wsp.name', name: 'wsp.name'},
                    {data: 'period', name: 'period'},
                    {data: 'coordinator', name: 'coordinator'},
                    {data: 'status', name: 'status',
                        render : function (data, type, row) {
                            return data == 'WASREB Approved' ? 'Pending Approval' : data
                        }
                    },
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
