@if (!empty(session('error')))
    <div class="alert alert-danger" role="alert">
        {{session('error')}}
    </div>
@endif


@if (!empty(session('success')))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
@endif

{{-- @if (!empty(session('success')))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
@endif --}}