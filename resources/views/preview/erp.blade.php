<div>
    <h4 class="text-center">EMERGENCY RESPONSE PLAN</h4>
    <p>{{ $eoi->date ? $eoi->date->format('d/m/Y') : now()->format('d/m/Y') }}</p>

    <p>A. <b>Coordinator</b></p>
    <p>{{$erp->coordinator}}</p>

    <p>B. <b>Period</b></p>
    <p>{{$erp->period}}</p>


    <p>C. <b>Resource Requirement:</b></p>

    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>COVID-19 Emergency Intervention</th>
            <th>Potential risks</th>
            <th>Potential Mitigation Measures</th>
            <th>Cost(KSHS)</th>
            <th>Others</th>
        </tr>
        </thead>
        @foreach($erp->erp_items as $item)
            <tr>
                <td>{{ $item->emergency_intervention }}</td>
                <td>{{ $item->risks }}</td>
                <td>
                    @foreach($item->mitigation as $mitigation)
                    <div>{{ $mitigation }}</div>
                    @endforeach
                </td>
                <td>{{ number_format($item->cost) }}</td>
                <td>{{ $item->other }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="1"><b>Total Costs</b></td>
            <td></td>
            <td></td>
            <td><b>{{ number_format($erp->erp_items->sum('cost')) }}</b></td>
        </tr>
    </table>
</div>
