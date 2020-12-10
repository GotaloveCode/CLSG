@extends('layouts.dashboard')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('View User') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('View User') }}
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
                            <h4 class="card-title">
                                View User
                            </h4>
                            <a class="heading-elements-toggle"><i
                                    class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    @can('delete-user')
                                        @if($edit_user->deleted_at)
                                            <li>
                                                <restore-user inline-template :user="{{ $edit_user }}">
                                                    <button class="btn btn-sm btn-info" @click.prevent="restoreUser"><i
                                                            class="feather icon-rewind"></i> Restore
                                                    </button>
                                                </restore-user>
                                            </li>
                                        @else
                                            <li>
                                                <delete-user inline-template :user="{{ $edit_user }}">
                                                    <button class="btn btn-sm btn-danger" @click.prevent="deleteUser"><i
                                                            class="feather icon-trash"></i> Delete
                                                    </button>
                                                </delete-user>
                                            </li>
                                        @endif
                                    @endcan
                                    <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $edit_user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $edit_user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ $edit_user->roles->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $edit_user->deleted_at ? 'Deleted' : 'Active' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
