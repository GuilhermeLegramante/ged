@if($sortBy !== $field)
<i style="color: lightgray; margin-right: -2px;" class="fas fa-arrow-up fa-xs"></i>
<i style="color: lightgray; margin-right: -2px;" class="fas fa-arrow-down fa-xs"></i>
@elseif ($sortDirection == 'asc')
<i style="color: black; margin-right: -2px" class="fas fa-arrow-up fa-xs"></i>
<i style="color: lightgray;" class="fas fa-arrow-down fa-xs"></i>
@else
<i style="color: lightgray; margin-right: -2px;" class="fas fa-arrow-up fa-xs"></i>
<i style="color: black" class="fas fa-arrow-down fa-xs"></i>
@endif