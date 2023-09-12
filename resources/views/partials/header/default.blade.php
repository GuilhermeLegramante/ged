<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6">
                <h1 class="m-0 text-dark"><i class="{{ $icon }}"></i> {{ $pageTitle }}</h1>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}"><i class="fas fa-laptop-house"></i> Início</a>
                    </li>
                    <li class="breadcrumb-item active"><i class="{{ $icon }}"></i> {{ $pageTitle }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@isset($pageDescription)
<div style="border-left-color: #0275d8;" class="callout callout-info">
    <h5><i class="fas fa-info-circle"></i> Info</h5>
    {!! $pageDescription !!}
</div>
@endisset
