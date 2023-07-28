<div>

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

    <!-- AUTOCEP CONTENT -->
    <div class="form-control w-1/2">
        <label for="{{ $prefix }}areacode" class="label">
            <span class="label-text">
                {{ __('livecontrols-autocep::autocep.areacode') }}
                @if($titlesuffix != '') {{ $titlesuffix }} @endif
            </span>
        </label>
        <input
            id="{{ $prefix }}areacode"
            name="{{ $prefix }}areacode"
            type="text"
            class="input input-bordered w-full"
            wire:model.debounce.250ms='cepvalue'
            value="{{ is_null($oldmodel) ? old($prefix.'areacode') : old($prefix.'areacode', $oldmodel->{$prefix.'areacode'}) }}"
            @if($required) required @endif
        />
        <x-input-error for="{{ $prefix }}areacode"></x-input-error>
        <p wire:loading wire:target='fetchInfos'>
            {{ __('livecontrols-autocep::autocep.searching') }}
        </p>
        @if($valid == 0)
            <span class="text-error" wire:loading.remove>
                {{ __('livecontrols-autocep::autocep.invalid_areacode') }}
            </span>
        @endif
    </div>

    <div class="grid grid-cols-3 gap-2">
        <div class="form-control w-auto col-span-2">
            <label for="{{ $prefix }}road" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.road') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix }}road"
                name="{{ $prefix }}road"
                type="text"
                class="input input-bordered w-full"
                wire:model='street'
                value="{{ is_null($oldmodel) ? old($prefix.'road') : old($prefix.'road', $oldmodel->{$prefix.'road'}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix }}road"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix }}housenumber" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.number') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix }}housenumber"
                name="{{ $prefix }}housenumber"
                type="text"
                class="input input-bordered w-full"
                value="{{ is_null($oldmodel) ? old($prefix.'housenumber') : old($prefix.'housenumber', $oldmodel->{$prefix.'housenumber'}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix }}housenumber"></x-input-error>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="form-control w-auto">
            <label for="{{ $prefix }}complement" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.complement') }}
                </span>
            </label>
            <input
                id="{{ $prefix }}complement"
                name="{{ $prefix }}complement"
                type="text"
                class="input input-bordered w-full"
                value="{{ is_null($oldmodel) ? old($prefix.'complement') : old($prefix.'complement', $oldmodel->{$prefix.'complement'}) }}"
            />
            <x-input-error for="{{ $prefix }}complement"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix }}bairro" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.area') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix }}bairro"
                name="{{ $prefix }}bairro"
                type="text"
                class="input input-bordered w-full"
                wire:model='bairro'
                value="{{ is_null($oldmodel) ? old($prefix.'bairro') : old($prefix.'bairro', $oldmodel->{$prefix.'bairro'}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix }}bairro"></x-input-error>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-2">
        <div class="form-control w-auto col-span-4">
            <label for="{{ $prefix }}city" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.city') }}
                </span>
            </label>
            <input
                id="{{ $prefix }}city"
                name="{{ $prefix }}city"
                type="text"
                class="input input-bordered w-full"
                wire:model='city'
                value="{{ is_null($oldmodel) ? old($prefix.'city') : old($prefix.'city', $oldmodel->{$prefix.'city'}) }}"
            />
            <x-input-error for="{{ $prefix }}city"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix }}uf" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.state') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix }}uf"
                name="{{ $prefix }}uf"
                type="text"
                maxlength="2"
                class="input input-bordered w-full"
                wire:model='uf'
                value="{{ is_null($oldmodel) ? old($prefix.'uf') : old($prefix.'uf', $oldmodel->{$prefix.'uf'}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix }}uf"></x-input-error>
        </div>
    </div>

    <input type="hidden" name="{{ $prefix }}country" value="Brazil">

    <!-- /AUTOCEP CONTENT -->

</div>