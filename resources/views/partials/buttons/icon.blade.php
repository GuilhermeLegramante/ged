@if (is_array($button))
    <button title="{{ $button['title'] }}" wire:click="{{ $button['method'] }}({{ $item->id }})"
        class="btn {{ $button['class'] }} btn-xs mr-1">
        <i class="{{ $button['icon'] }}"></i>
    </button>
@else
    <button title="{{ $button->title }}" wire:click="{{ $button->method }}({{ $item->id }})"
        class="btn {{ $button->class }} btn-xs mr-1">
        <i class="{{ $button->icon }}"></i> 
    </button>
@endif
