@extends('layouts.dashboard')
@push('css')
<link rel="stylesheet" type="text/css"
      href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('List of WSP') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('List of WSP') }}
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
                            <table class="table" id="wsps-table">
                                <thead>
                                <tr>
                                    <th>Wsp</th>
                                    <th>Acronym</th>
                                    <th>Email</th>
                                    <th>Managing Director</th>
                                    <th>Postal Address</th>
                                    <th>Created At</th>
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
            $('#wsps-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('wsps.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'acronym', name: 'acronym'},
                    {data: 'email', name: 'email'},
                    {data: 'managing_director', name: 'managing_director'},
                    {data: 'postal_address', name: 'postal_address'},
                    {data: 'created_at', name: 'created_at'},
                ]
            });
        });
    </script>
@endpush
