<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Veículos cadastrados</h1>
                <p class="text-sm text-gray-500">Gerencie as ofertas disponíveis no catálogo público.</p>
            </div>
            <a href="{{ route('admin.vehicles.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                Novo veículo
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.status')

            <div class="grid gap-6">
                @forelse ($vehicles as $vehicle)
                    <article class="flex flex-col gap-6 rounded-3xl bg-white p-6 shadow ring-1 ring-gray-200 md:flex-row md:items-center">
                        <img src="{{ $vehicle->main_photo_url }}" alt="Foto de {{ $vehicle->title }}" class="h-40 w-full rounded-2xl object-cover md:h-32 md:w-48">

                        <div class="flex-1 space-y-3">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $vehicle->title }}</h2>
                                <p class="text-sm text-gray-500">
                                    {{ $vehicle->brand->name }} &middot; {{ $vehicle->model->name }} &middot; {{ $vehicle->color->name }}
                                </p>
                            </div>

                            <dl class="flex flex-wrap items-center gap-x-8 gap-y-2 text-sm text-gray-600">
                                <div>
                                    <dt class="font-medium text-gray-500">Ano</dt>
                                    <dd class="font-semibold text-gray-900">{{ $vehicle->year }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Quilometragem</dt>
                                    <dd class="font-semibold text-gray-900">{{ number_format($vehicle->mileage, 0, ',', '.') }} km</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Valor</dt>
                                    <dd class="text-lg font-bold text-indigo-600">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500">Criado em</dt>
                                    <dd class="font-semibold text-gray-900">{{ $vehicle->created_at->format('d/m/Y') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('vehicles.show', $vehicle) }}" target="_blank" class="rounded-lg border border-indigo-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-indigo-600 transition hover:border-indigo-400 hover:text-indigo-700">
                                Ver na vitrine
                            </a>
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="rounded-lg border border-amber-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-amber-600 transition hover:border-amber-400 hover:text-amber-700">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Deseja remover este veículo do catálogo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-lg border border-rose-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-rose-600 transition hover:border-rose-400 hover:text-rose-700">
                                    Remover
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl bg-white px-8 py-12 text-center shadow ring-1 ring-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Nenhum veículo cadastrado ainda.</h2>
                        <p class="mt-3 text-gray-500">Clique em “Novo veículo” para adicionar o primeiro anúncio ao catálogo.</p>
                    </div>
                @endforelse
            </div>

            {{ $vehicles->links() }}
        </div>
    </div>
</x-app-layout>
