<div class="card-header">
    <h4>ESSENTIAL OPERATIONS</h4>
</div>
<div class="table-responsive">
    <table class="table mb-0">
        <thead>
        <tr>
            <th>Description</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
        </thead>
        <tbody>
        @foreach(json_decode($essential->details) as $ess)
            <tr>
                <td>{{$checklist->firstWhere('id',$ess->id)->name}} </td>
                <td><span class="badge
@if($ess->status == 'Completed') badge-success
@elseif($ess->status == 'In Progress') badge-warning
@else badge-danger
@endif">{{ $ess->status }}</span></td>
                <td>{{$ess->comment}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
