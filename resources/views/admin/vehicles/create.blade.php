@php
    $photoInputs = collect(old('photos', []))->pad(3, '');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Novo veículo</h1>
                <p class="text-sm text-gray-500">Cadastre um veículo completo com pelo menos três fotos.</p>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">&larr; Voltar para a listagem</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @include('admin.partials.status')

            <form method="POST" action="{{ route('admin.vehicles.store') }}" class="space-y-8 rounded-3xl bg-white p-8 shadow ring-1 ring-gray-200">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input-label for="title" value="Título do anúncio" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" required />
                        <p class="mt-1 text-xs text-gray-500">Ex.: Honda HR-V Touring Turbo 1.5 2022</p>
                    </div>

                    <div>
                        <x-input-label for="brand_id" value="Marca" />
                        <select id="brand_id" name="brand_id" class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Selecione</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="car_model_id" value="Modelo" />
                        <select id="car_model_id" name="car_model_id" class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Selecione</option>
                            @foreach ($models as $model)
                                <option value="{{ $model->id }}" data-brand="{{ $model->brand_id }}" @selected(old('car_model_id') == $model->id)>
                                    {{ $model->name }} ({{ $model->brand->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="color_id" value="Cor" />
                        <select id="color_id" name="color_id" class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Selecione</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" @selected(old('color_id') == $color->id)>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="year" value="Ano de fabricação" />
                        <x-text-input id="year" name="year" type="number" min="1960" max="{{ now()->year + 1 }}" class="mt-1 block w-full" value="{{ old('year') }}" required />
                    </div>

                    <div>
                        <x-input-label for="mileage" value="Quilometragem (km)" />
                        <x-text-input id="mileage" name="mileage" type="number" min="0" step="1" class="mt-1 block w-full" value="{{ old('mileage') }}" required />
                    </div>

                    <div>
                        <x-input-label for="price" value="Valor (R$)" />
                        <x-text-input id="price" name="price" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('price') }}" required />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Descrição detalhada" />
                    <textarea id="description" name="description" rows="6" class="mt-1 block w-full rounded-lg border-gray-300 text-sm leading-relaxed focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Descreva diferenciais, histórico de manutenção, opcionais e condições especiais.</p>
                </div>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900">Fotos do veículo</h2>
                    <p class="mt-1 text-sm text-gray-500">Informe pelo menos três links válidos. Escolha qual será a foto principal.</p>

                    <div id="photos-wrapper" class="mt-4 space-y-4">
                        @foreach ($photoInputs as $index => $photo)
                            <div class="rounded-2xl border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <x-input-label :for="'photo_'.$index" :value="'Foto #'.($index + 1)" />
                                    <label class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-indigo-600">
                                        <input type="radio" name="main_photo_index" value="{{ $index }}" @checked(old('main_photo_index', 0) == $index) class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        Foto principal
                                    </label>
                                </div>
                                <x-text-input id="photo_{{ $index }}" name="photos[]" type="url" class="mt-2 block w-full" value="{{ $photo }}" required />
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-photo" class="mt-4 inline-flex items-center rounded-lg border border-dashed border-indigo-300 px-4 py-2 text-sm font-semibold text-indigo-600 hover:border-indigo-500 hover:text-indigo-700">
                        + Adicionar outra foto
                    </button>
                </section>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.vehicles.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <x-primary-button>
                        Publicar veículo
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const brandSelect = document.getElementById('brand_id');
            const modelSelect = document.getElementById('car_model_id');
            const addPhotoButton = document.getElementById('add-photo');
            const photosWrapper = document.getElementById('photos-wrapper');

            const filterModels = () => {
                const brandId = brandSelect.value;
                const options = Array.from(modelSelect.options);

                options.forEach(option => {
                    if (!option.value) return;
                    option.hidden = brandId && option.dataset.brand !== brandId;
                });

                const selectedOption = options.find(option => option.value === modelSelect.value);
                if (selectedOption && !selectedOption.hidden) {
                    return;
                }

                const firstVisible = options.find(option => !option.hidden && option.value);
                modelSelect.value = firstVisible ? firstVisible.value : '';
            };

            if (brandSelect && modelSelect) {
                filterModels();
                brandSelect.addEventListener('change', filterModels);
            }

            let photoIndex = {{ $photoInputs->count() }};

            addPhotoButton?.addEventListener('click', () => {
                const container = document.createElement('div');
                container.className = 'rounded-2xl border border-gray-200 p-4';

                container.innerHTML = `
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700" for="photo_${photoIndex}">
                            Foto #${photoIndex + 1}
                        </label>
                        <label class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-indigo-600">
                            <input type="radio" name="main_photo_index" value="${photoIndex}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            Foto principal
                        </label>
                    </div>
                    <input id="photo_${photoIndex}" name="photos[]" type="url" required class="mt-2 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                `;

                photosWrapper.appendChild(container);
                photoIndex += 1;
            });
        });
    </script>
</x-app-layout>
