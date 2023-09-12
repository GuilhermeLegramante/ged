@if(count($register) > 0)
<div wire:ignore.self class="card card-primary card-outline sticky-top">
    <div class="card-header" data-card-widget="collapse">
        <div class="row mt-1">
            <div class="col-sm-7">
                <h3 class="card-title cardTitleCustom"><strong> {{ $cardDetailsTitle }}</strong></h3> <br>
            </div>
        </div>
        <div class="card-tools mt-n3">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body mb-n2">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table-bordered table-striped pd-10px w-100">
                        <tbody>
                            @foreach ($register as $item)
                            @if($item['value'] == 'groupHeader')
                            <tr>
                                <th colspan="2" class="p-1 bg-light text-center">{{ $item['label'] }}</th>
                            </tr>
                            @else
                            <tr>
                                <th class="p-1">{{ $item['label'] }}</th>
                                @if(isset($item['url']))
                                <td class="p-1"> <a target="_blank" href="{{ $item['value'] }}">{{ $item['value'] }}</a> </td>
                                @else
                                <td class="p-1">{{ $item['value'] }}</td>
                                @endif
                            </tr>
                            @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endif
