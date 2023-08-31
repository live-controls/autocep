<div>

    @once
        @push('scripts')
        <script src="https://unpkg.com/imask"></script>
        <script type="text/javascript">
            window.{{ $prefix.$areacodeName }}mask = IMask(
                document.getElementById('{{ $prefix.$areacodeName }}'),
                {
                    mask: '00000-000'
                }
            );

            document.addEventListener("DOMContentLoaded", () => {
                @if(!is_null($cep))
                    window.{{ $prefix.$areacodeName }}mask.value = "{{ $cep }}";
                @endif
            });

            Livewire.on('{{ $prefix.$areacodeName }}-valueUpdated', value => {
                @this.cep = window.{{ $prefix.$areacodeName }}mask.unmaskedValue;
                Livewire.emit('cepUpdated');
            });
        </script>
        @endpush
    @endonce

    <!-- AUTOCEP CONTENT -->
    <div class="form-control w-1/2">
        <label for="{{ $prefix.$areacodeName }}" class="label">
            <span class="label-text">
                {{ __('livecontrols-autocep::autocep.areacode') }}
                @if($titlesuffix != '') {{ $titlesuffix }} @endif
            </span>
        </label>
        <input
            id="{{ $prefix.$areacodeName }}"
            name="{{ $prefix.$areacodeName }}"
            type="text"
            class="input input-bordered w-full"
            wire:model.debounce.250ms='cepvalue'
            value="{{ is_null($oldmodel) ? old($prefix.$areacodeName) : old($prefix.$areacodeName, $oldmodel->{$prefix.$areacodeName}) }}"
            @if($required) required @endif
        />
        <x-input-error for="{{ $prefix.$areacodeName }}"></x-input-error>
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
            <label for="{{ $prefix.$streetName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.street') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$streetName }}"
                name="{{ $prefix.$streetName }}"
                type="text"
                class="input input-bordered w-full"
                wire:model='street'
                value="{{ is_null($oldmodel) ? old($prefix.$streetName) : old($prefix.$streetName, $oldmodel->{$prefix.$streetName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$streetName }}"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix.$numberName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.number') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$numberName }}"
                name="{{ $prefix.$numberName }}"
                type="text"
                class="input input-bordered w-full"
                value="{{ is_null($oldmodel) ? old($prefix.$numberName) : old($prefix.$numberName, $oldmodel->{$prefix.$numberName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$numberName }}"></x-input-error>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="form-control w-auto">
            <label for="{{ $prefix.$complementName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.complement') }}
                </span>
            </label>
            <input
                id="{{ $prefix.$complementName }}"
                name="{{ $prefix.$complementName }}"
                type="text"
                class="input input-bordered w-full"
                value="{{ is_null($oldmodel) ? old($prefix.$complementName) : old($prefix.$complementName, $oldmodel->{$prefix.$complementName}) }}"
            />
            <x-input-error for="{{ $prefix.$complementName }}"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix.$areaName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.area') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$areaName }}"
                name="{{ $prefix.$areaName }}"
                type="text"
                class="input input-bordered w-full"
                wire:model='area'
                value="{{ is_null($oldmodel) ? old($prefix.$areaName) : old($prefix.$areaName, $oldmodel->{$prefix.$areaName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$areaName }}"></x-input-error>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-2">
        <div class="form-control w-auto col-span-4">
            <label for="{{ $prefix.$cityName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.city') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$cityName }}"
                name="{{ $prefix.$cityName }}"
                type="text"
                class="input input-bordered w-full"
                wire:model='city'
                value="{{ is_null($oldmodel) ? old($prefix.$cityName) : old($prefix.$cityName, $oldmodel->{$prefix.$cityName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$cityName }}"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix.$ufName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autocep::autocep.state') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$ufName }}"
                name="{{ $prefix.$ufName }}"
                type="text"
                maxlength="2"
                class="input input-bordered w-full"
                wire:model='uf'
                value="{{ is_null($oldmodel) ? old($prefix.$ufName) : old($prefix.$ufName, $oldmodel->{$prefix.$ufName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$ufName }}"></x-input-error>
        </div>
    </div>

    <input type="hidden" name="{{ $prefix.$countryName }}" value="Brazil">

    <!-- /AUTOCEP CONTENT -->

</div>