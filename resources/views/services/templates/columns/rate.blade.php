<div class="text-end pe-25">
    @if($row->rate)
        {{ checkNumberFormat($row->rate, strtoupper(getCurrentCurrency())) }}
    @else
        {{ __('messages.common.n/a') }}
    @endif
</div>
