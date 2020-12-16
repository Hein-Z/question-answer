@if(session()->has('msg'))
    <div
        class='alert-success alert alert-dismissible fade show d-flex justify-content-between align-items-center pr-0'
        role="alert">
        <div class="h3">
            {{ session()->get('msg') }}
        </div>
        <button type="button" class="close position-relative" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
