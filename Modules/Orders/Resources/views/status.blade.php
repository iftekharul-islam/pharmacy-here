@if(isset($status))
    @if($status == 0)
        <span class="badge badge-warning">Pending</span>
    @elseif($status == 1)
        <span class="badge badge-success">Accepted</span>
    @elseif($status == 2)
        <span class="badge badge-success">Processing</span>
    @elseif($status == 9)
        <span class="badge badge-success">On The Way</span>
    @elseif($status == 10)
        <span class="badge badge-danger">Canceled</span>
    @endif
@endif
