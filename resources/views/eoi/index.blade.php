@extends('layouts.dashboard')
@push('css')
{{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">--}}
<link rel="stylesheet" type="text/css"
      href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('List of Expression Of Interest') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('List of Expression Of Interest') }}
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
                            <table class="table" id="eois-table">
                                <thead>
                                <tr>
                                    <th>Wsp</th>
                                    <th>Fixed Grant</th>
                                    <th>Variable Grant</th>
                                    <th>Emergency Intervention Total</th>
                                    <th>Operation Costs Total</th>
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
{{--    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>--}}
    <script defer>
        $(function () {
            $('#eois-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('eois.index') !!}',
                columns: [
                    {data: 'wsp.name', name: 'wsp.name'},
                    {data: 'fixed_grant', name: 'fixed_grant', render: $.fn.dataTable.render.number(',', '.', 2,'')},
                    {data: 'variable_grant', name: 'variable_grant', render: $.fn.dataTable.render.number(',', '.', 2,'')},
                    {data: 'emergency_intervention_total', name: 'emergency_intervention_total', render: $.fn.dataTable.render.number(',', '.', 2,'')},
                    {data: 'operation_costs_total', name: 'operation_costs_total', render: $.fn.dataTable.render.number(',', '.', 2,'')},
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
