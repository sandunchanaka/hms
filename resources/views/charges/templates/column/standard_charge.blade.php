<div class="text-end pe-25">
    @if(!empty($row->standard_charge))
        <p class="cur-margin">
            {{ checkNumberFormat($row->standard_charge, strtoupper(getCurrentCurrency())) }}
        </p>
    @else
        {{ __('messages.common.n/a')}}
    @endif
</div>
