@if(isset($status))
    @if($status == 0)
        <span class="badge badge-warning">Pending</span>
    @elseif($status == 1)
        <span class="badge badge-success">Accepted</span>
    @elseif($status == 2)
        <span class="badge badge-info">Processing</span>
    @elseif($status == 3)
        <span class="badge badge-success">Completed</span>
    @elseif($status == 9)
        <span class="badge badge-info">On The Way</span>
    @elseif($status == 10)
        <span class="badge badge-danger">Cancelled</span>
    @elseif($status == 8)
        <span class="badge badge-danger">Orphan</span>
    @endif
@endif
