@extends('layouts.dashboard')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{ __('Staff View') }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('staff.index')}}">Staff List</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Staff View') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <manage-staff inline-template class="content-body" :staff="{{$staff}}">
                <div class="card">
                    <modal
                        :show-modal="show_edit_dialog"
                        @close="show_edit_dialog = false"
                    >
                        <template v-slot:header>
                            <h5>Edit Staff</h5>
                        </template>
                        <staff-form :existing-staff="{{ $staff }}" wspid="{{$staff->wsp_id}}"/>
                    </modal>
                    <div class="card-header">
                        <h4 class="card-title">Profile</h4>
                        <a class="heading-elements-toggle"><i
                                class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                @can('create-staff')
                                    <li>
                                        <button class="btn btn-info btn-sm" @click.prevent="show_edit_dialog=true"><i
                                                class="feather icon-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" @click.prevent="deleteStaff"><i
                                                class="feather icon-trash"></i>
                                            Delete
                                        </button>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $staff->firstname }} {{ $staff->lastname }}</td>
                                </tr>
                                <tr>
                                    <td>Position</td>
                                    <td>{{ $staff->position }}</td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>{{ $staff->type }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $staff->email }}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{ $staff->phone }}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </manage-staff>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="text-bold-500">Skills</h5>
                </div>
                <div class="card-content card-body">
                    {{ $staff->skills }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="text-bold-500">Qualifications</h5>
                </div>
                <div class="card-content card-body">
                    {{ $staff->qualifications }}
                </div>
            </div>
        </div>
    </div>
@endsection
