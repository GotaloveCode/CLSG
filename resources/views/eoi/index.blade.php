@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <div class="container">
        <table class="table table-bordered" id="eois-table">
            <thead>
            <tr>
                <th>Wsp</th>
                <th>Fixed Grant</th>
                <th>Variable Grant</th>
                <th>Emergency Intervention Total</th>
                <th>Operation Costs Total</th>
                <th>Created At</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script defer>
        $(function () {
            $('#eois-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('eois.list') !!}',
                columns: [
                    {data: 'wsp.name', name: 'wsp.name'},
                    {data: 'fixed_grant', name: 'fixed_grant'},
                    {data: 'variable_grant', name: 'variable_grant'},
                    {data: 'emergency_intervention_total', name: 'emergency_intervention_total'},
                    {data: 'operation_costs_total', name: 'operation_costs_total'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
