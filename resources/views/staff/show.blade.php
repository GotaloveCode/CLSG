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
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 pb-1 mb-1 border-bottom-blue-grey border-bottom-lighten-5">
                            <button class="btn btn-info" @click.prevent="show_edit_dialog=true"><i
                                    class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger" @click.prevent="deleteStaff"><i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                        <div class="col-md-4"><label class="control-label">Name</label>
                            <p class="form-control-static">{{ $staff->firstname }} {{ $staff->lastname }}</p>
                        </div>
                        <div class="col-md-4"><label class="control-label">Position</label>
                            <p class="form-control-static">{{ $staff->position }}</p>
                        </div>
                        <div class="col-md-4"><label class="control-label">Type</label>
                            <p class="form-control-static">{{ $staff->type }}</p>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Wsp</label>
                            <p class="form-control-static">{{ $staff->wsp->name }}</p>
                        </div>
                        <div class="col-md-6"><label class="control-label">Skills</label>
                            <div class="form-control-static">{{ $staff->skills }}</div>
                        </div>
                        <div class="col-md-6"><label class="control-label">Qualifications</label>
                            <div class="form-control-static">{{ $staff->qualifications }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </manage-staff>
@endsection
