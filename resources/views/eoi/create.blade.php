@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Expression Of Interest Form') }}</div>
                <div class="card-body">
                    <eoi-form submit-url="{{ route('eoi.store') }}"></eoi-form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

{{--<table class="table">--}}
{{--    <tr>--}}
{{--        <th colspan="3">People Served By</th>--}}
{{--    </tr>--}}
{{--    @foreach($connections as $connection)--}}
{{--        <tr>--}}
{{--            <td>{{$connection->name}}</td>--}}
{{--            <td><input type="text" class="form-control" name="aconnection->id}}"></td>--}}
{{--            <td><input type="number" class="form-control" name="total_{{$connection->id}}"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    <tr>--}}
{{--        <th>Estimated costs</th>--}}
{{--        <th>Unit Cost (KES) </th>--}}
{{--        <th>Total cost (KES) </th>--}}
{{--    </tr>--}}
{{--    @foreach($connections as $connection)--}}
{{--        <tr>--}}
{{--            <td>{{$connection->name}}</td>--}}
{{--            <td><input type="text" class="form-control" name="aconnection->id}}"></td>--}}
{{--            <td><input type="number" class="form-control" name="total_{{$connection->id}}"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--</table>--}}
