@if(isset($status))
    @if($status == 1)
        <span style="display: none; visibility: hidden">1</span>
        <button type="button" class="btn btn-success btn-sm-status waves-effect waves-light d-flex align-items-center">
            <i class="fa fa-check"></i></button>
    @else
        <span style="display: none; visibility: hidden">0</span>
        <button type="button" class="btn btn-danger btn-sm-status waves-effect waves-light d-flex align-items-center"><i
                class="fa fa-times"></i></button>
    @endif
@endif
