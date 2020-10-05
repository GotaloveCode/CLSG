@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($errors && count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(Session::has('alerts'))
                    @foreach(Session::get('alerts') as $alert)
                        <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show m-3" role="alert">
                            {!! $alert['message'] !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h4 class="card-title pull-left">
                            Import System Users
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{Route('wsps.import')}}" enctype="MULTIPART/FORM-DATA">
                            @csrf
                            <table class="table table-striped  table-hover table-advance dt-responsive" width="100%">
                                <thead>
                                <tr>
                                    <th>Column</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Name (Required)</td>
                                </tr>
                                <tr>
                                    <td>Acronym (Required)</td>
                                </tr>
                                <tr>
                                    <td>Email (Required)</td>
                                </tr>
                                <tr>
                                    <td>Postal Address (Required)</td>
                                </tr>
                                <tr>
                                    <td>Physical Address (Required)</td>
                                </tr>
                                <tr>
                                    <td>Postal Code (Required)</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-info">
                                <div>
                                    If you are not sure how this is done, download the template <a
                                        class="btn btn-outline-info btn-sm"
                                        href="{{route('wsps.export',['export-csv'=>'export'])}}">
                                        Download Template
                                    </a>
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('file')? 'has-error': ''}}">
                                <label>Select File (Excel/CSV)</label>
                                <input type="file" class="form-control" name="file" required>
                                {!! $errors->first('file', '<span class="text-danger">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

