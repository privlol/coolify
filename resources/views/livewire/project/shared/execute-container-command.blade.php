<div>
    <x-slot:title>
        {{ data_get_str($resource, 'name')->limit(10) }} > Commands | Coolify
    </x-slot>
    <livewire:project.shared.configuration-checker :resource="$resource" />
    @if ($type === 'application')
        <h1>Execute Command</h1>
        <livewire:project.application.heading :application="$resource" />
        <h2 class="pt-4">Command</h2>
        <div class="pb-2">Run any one-shot command inside a container.</div>
    @elseif ($type === 'database')
        <h1>Execute Command</h1>
        <livewire:project.database.heading :database="$resource" />
        <h2 class="pt-4">Command</h2>
        <div class="pb-2">Run any one-shot command inside a container.</div>
    @elseif ($type === 'service')
        <h2>Execute Command</h2>
    @endif
    <div x-init="$wire.loadContainers">
        <div class="pt-4" wire:loading wire:target='loadContainers'>
            Loading containers...
        </div>
        <div wire:loading.remove wire:target='loadContainers'>
            @if (count($containers) > 0)
                <form class="flex flex-col justify-center gap-2 pt-4 xl:items-end xl:flex-row"
                    wire:submit="$dispatchSelf('connectToContainer')">
                    <x-forms.select label="Container" id="container" required>
                        <option disabled selected>Select container</option>
                        @if (data_get($this->parameters, 'application_uuid'))
                            @foreach ($containers as $container)
                                <option value="{{ data_get($container, 'container.Names') }}">
                                    {{ data_get($container, 'container.Names') }} ({{ data_get($container, 'server.name') }})
                                </option>
                            @endforeach
                        @elseif(data_get($this->parameters, 'service_uuid'))
                            @foreach ($containers as $container)
                                <option value="{{ $container }}">
                                    {{ $container }} ({{ data_get($servers, '0.name') }})
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $container }}">
                                {{ $container }} ({{ data_get($servers, '0.name') }})
                            </option>
                        @endif
                    </x-forms.select>
                    <x-forms.button type="submit">Start Connection</x-forms.button>
                </form>
            @else
                <div class="pt-4">No containers are not running.</div>
            @endif
        </div>
    </div>
    <div class="w-full mx-auto">
        <livewire:project.shared.terminal />
    </div>
</div>
