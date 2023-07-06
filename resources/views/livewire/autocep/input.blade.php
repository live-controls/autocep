<div class="row g-3">

    @once
        @push('scripts')
        <script src="https://unpkg.com/imask"></script>
        <script type="text/javascript">
            window.{{ $prefix }}areacodemask = IMask(
                document.getElementById('{{ $prefix }}areacode'),
                {
                    mask: '00000-000'
                }
            );

            document.addEventListener("DOMContentLoaded", () => {
                @if(!is_null($cep))
                    window.{{ $prefix }}areacodemask.value = "{{ $cep }}";
                @endif
            });

            Livewire.on('{{ $prefix }}areacode-valueUpdated', value => {
                @this.cep = window.{{ $prefix }}areacodemask.unmaskedValue;
                Livewire.emit('cepUpdated');
            });
        </script>
        @endpush
    @endonce
    <div class="row">
        <div class="col-md-6">
            <label for="{{ $prefix }}areacode" class="form-label">{{ __('livecontrols::autocep.areacode') }} @if($titlesuffix != '') {{ $titlesuffix }} @endif</label>
            <input @if($titlesuffix != '') required @endif wire:model.debounce.250ms='cepvalue' type="text" class="form-control {{ $errors->has($prefix.'areacode') ? 'is-invalid' : '' }}" id="{{ $prefix }}areacode" name="{{ $prefix }}areacode" value="{{ old($prefix.'areacode') }}" @if($required) required @endif>
            <x-jet-input-error for="{{ $prefix }}areacode"></x-jet-input-error>
            <span wire:loading wire:target='fetchInfos'>{{ __('livecontrols::autocep.searching') }}</span>
            @if($valid == 0)
            <span style="color: red;" wire:loading.remove>{{ __('livecontrols::autocep.invalid_areacode') }}</span>
            @endif
        </div>
    </div>

    <div class="col-md-5">
        <label for="{{ $prefix }}road" class="form-label">{{ __('livecontrols::autocep.road') }} @if($titlesuffix != '') {{ $titlesuffix }} @endif</label>
        <input @if($titlesuffix != '') required @endif wire:model='street' type="text" class="form-control {{ $errors->has($prefix.'road') ? 'is-invalid' : '' }}" id="{{ $prefix }}road" name="{{ $prefix }}road" value="{{ old($prefix.'road') }}" @if($required) required @endif>
        <x-jet-input-error for="{{ $prefix }}road"></x-jet-input-error>
    </div>
    <div class="col-md-3">
        <label for="{{ $prefix }}housenumber" class="form-label">{{ __('livecontrols::autocep.number') }} @if($titlesuffix != '') {{ $titlesuffix }} @endif</label>
        <input @if($titlesuffix != '') required @endif type="text" class="form-control {{ $errors->has($prefix.'housenumber') ? 'is-invalid' : '' }}" id="{{ $prefix }}housenumber" name="{{ $prefix }}housenumber" value="{{ is_null($oldmodel) ? old($prefix.'housenumber') : old($prefix.'housenumber', $oldmodel->{$prefix.'housenumber'}) }}" @if($required) required @endif>
        <x-jet-input-error for="{{ $prefix }}housenumber"></x-jet-input-error>
    </div>
    <div class="col-md-4">
        <label for="{{ $prefix }}complement" class="form-label">{{ __('livecontrols::autocep.complement') }}</label>
        <input type="text" class="form-control {{ $errors->has($prefix.'complement') ? 'is-invalid' : '' }}" id="{{ $prefix }}complement" name="{{ $prefix }}complement" value="{{ is_null($oldmodel) ? old($prefix.'complement') : old($prefix.'complement', $oldmodel->{$prefix.'complement'}) }}">
        <x-jet-input-error for="{{ $prefix }}complement"></x-jet-input-error>
    </div>
    <div class="col-md-4">
        <label for="{{ $prefix }}bairro" class="form-label">{{ __('livecontrols::autocep.area') }} @if($titlesuffix != '') {{ $titlesuffix }} @endif</label>
        <input @if($titlesuffix != '') required @endif wire:model='bairro' type="text" class="form-control {{ $errors->has($prefix.'bairro') ? 'is-invalid' : '' }}" id="{{ $prefix }}bairro" name="{{ $prefix }}bairro" value="{{ old($prefix.'bairro') }}" @if($required) required @endif>
        <x-jet-input-error for="{{ $prefix }}bairro"></x-jet-input-error>
    </div>
    <div class="col-md-4">
        <label for="{{ $prefix }}city" class="form-label">{{ __('livecontrols::autocep.city') }} @if($titlesuffix != '') {{ $titlesuffix }} @endif</label>
        <input @if($titlesuffix != '') required @endif wire:model='city' type="text" class="form-control {{ $errors->has($prefix.'city') ? 'is-invalid' : '' }}" id="{{ $prefix }}city" name="{{ $prefix }}city" value="{{ old($prefix.'city') }}" @if($required) required @endif>
        <x-jet-input-error for="{{ $prefix }}city"></x-jet-input-error>
    </div>
    <div class="col-md-2">
        <label for="{{ $prefix }}state" class="form-label">{{ __('livecontrols::autocep.state') }} @if($titlesuffix != '') {{ $titlesuffix }} @endif</label>
        <input @if($titlesuffix != '') required @endif wire:model='uf' type="text" class="form-control {{ $errors->has($prefix.'state') ? 'is-invalid' : '' }}" id="{{ $prefix }}state" name="{{ $prefix }}state" value="{{ old($prefix.'state') }}" @if($required) required @endif>
        <x-jet-input-error for="{{ $prefix }}state"></x-jet-input-error>
    </div>
    <input type="hidden" name="{{ $prefix }}country" value="Brazil">
</div>
