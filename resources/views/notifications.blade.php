@extends('layouts.dashboard')
@push('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endpush
@section('content')
    @csrf
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Notifications') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Notifications') }}
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
                        <button class="btn btn-warning mb-1" id="markAll">Mark all as Read</button>
                        <div class="table-responsive">
                            <table class="table" id="eois-table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Comment</th>
                                    <th>Posted</th>
                                    <th></th>
                                </tr>
                                </thead>
                                @foreach($notifications as $notification)
                                    <tr>
                                        <td>{{ $notification->data['title'] }}</td>
                                        <td>{{ $notification->data['details'] }}</td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ $notification->data['url'] }}" class="btn btn-info btn-sm"><i
                                                    class="feather icon-eye"> View</i></a>
                                            <button class="btn btn-sm btn-warning mark-read"
                                                    data-id="{{$notification->id}}"><i
                                                    class="feather icon-check-circle"></i> Mark as read
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
            $('#eois-table').DataTable();
            $("body").on("click", ".mark-read", function () {
                let id = $(this).data("id");
                $.ajax({
                    url: '/notifications/' + id,
                    data: {
                        _token:'{{ csrf_token() }}'
                    },
                    type: 'PUT',
                    dataType: 'json',
                    success: function (response) {
                        window.Vue.swal("Success",response.message);
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            $("#markAll").click(function () {
                $.post({
                    url: '/notifications',
                    data: {
                        _token:'{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        window.Vue.swal("Success",response.message);
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            })
        });
    </script>
@endpush
