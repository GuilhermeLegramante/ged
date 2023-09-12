<div>
    @if (session()->has('error'))
    <div wire:ignore.self class="card card-danger collapsed-card pointer">
        <div class="card-header">
            <p class="card-title"> <small><strong>{!! session('error') !!}</strong></small>
            </p>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <p><small>{!! session('error-details') !!}</small></p>
        </div>
    </div>
    @endif

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
    </div>
    @endif
</div>
