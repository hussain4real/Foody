<div class="container mx-auto max-w-2xl pt-6">
    <form wire:submit="create">
        {{ $this->form }}

        <button type="submit">
            Submit
        </button>
    </form>

    <x-filament-actions::modals/>
</div>
