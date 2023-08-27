<div class="container mx-auto max-w-2xl pt-6">

    <form wire:submit="save">
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="form.name" type="text" class="mt-1 block w-full" wire:model="form.name"
                      autofocus
                      autocomplete="name"/>


        <x-input-error class="mt-2" :messages="$errors->get('form.name')"/>


        <x-input-label for="description" :value="__('Description')"/>
        <x-textarea-input id="description" name="form.description" class="mt-3 block w-full"
                          wire:model="form.description"
                          autofocus
                          autocomplete="description"/>

        <x-input-error class="mt-2" :messages="$errors->get('form.description')"/>

        <x-select-input id="type" name="form.type" class="mt-3 block max-w-7xl appearance-none"
                        wire:model="form.type"
                        autofocus
                        autocomplete="type">
            <option disabled>{{ __('Select a category') }}</option>
            @foreach($foodTypes as $foodType)

                <option value="{{$foodType}}">{{$foodType}}</option>
            @endforeach

        </x-select-input>
        <div
            x-data="{ uploading: false, progress: 0 }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <x-file-input id="form.photos" name="form.photos" class="mt-4 block w-full"
                          wire:model="form.photos"
                          type="file" multiple
            />
            <div class="block text-green-600 font-semibold my-4 bg-slate200" wire:loading.delay
                 wire:target="form.photos.*">
                Uploading...
            </div>
            <div x-show="uploading" wire:target="form.photos.*">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('form.photos')"/>
            @error('form.photos.*') <span
                class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1">{{ $message }}</span> @enderror

        </div>
        @if ($photos)

            <div class="flex items-center justify-center snap-mandatory snap-x space-x-4 overflow-scroll py-4">
                @foreach($photos as $photo)
                    <div class="snap-start flex-shrink-0 w-48 h-48">
                        <img src="{{ $photo->temporaryUrl() }}" class="w-48 h-48">
                    </div>
                @endforeach
            </div>

        @endif
        <x-primary-button type="submit" class="mt-2" wire:loading.class="opacity-50 cursor-progress">
            {{ __('Save') }}
        </x-primary-button>
    </form>


    {{--    <form wire:submit="save">--}}
    {{--        <input type="text" wire:model="form.name">--}}
    {{--        <div>--}}
    {{--            @error('form.name') <span class="error">{{ $message }}</span> @enderror--}}
    {{--        </div>--}}

    {{--        <input type="text" wire:model="form.description">--}}
    {{--        <div>--}}
    {{--            @error('form.description') <span class="error">{{ $message }}</span> @enderror--}}
    {{--        </div>--}}

    {{--        <button type="submit">Save</button>--}}
    {{--    </form>--}}
</div>
