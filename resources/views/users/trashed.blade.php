@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-1">
            <h3 class="content-header-title mb-0">{{ __('Deleted Users') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Deleted Users') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content-body">
        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="users-list-datatable">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
    </section>


@endsection
@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script>
        $(function () {
            $('#users-list-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('users.trashed') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'roles', name: 'role',
                        render: function (data, type, row, meta) {
                            return type === 'display' ?
                                data.map(x => x.name.toUpperCase()).join(', ') : data;
                        }
                    },
                    {data: 'created_at', name: 'created_at'},
                        @can('delete-users')
                    {
                        data: 'id',
                        name: 'action', orderable: false, searchable: false,
                        render: function (data, type, row, meta) {
                            return type === 'display' ?
                                '<a href="/users/' + data + '"  class="btn btn-sm btn-primary"><i class="feather icon-eye"></i> View</a>' :
                                data;
                        }
                    }
                    @endcan
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
