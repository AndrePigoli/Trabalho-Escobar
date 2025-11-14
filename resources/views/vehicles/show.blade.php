@extends('layouts.public')

@section('title', $vehicle->title . ' | andreCarros')

@section('hero')
    <section class="page-hero">
        <div class="grid gap-8 lg:grid-cols-[1.35fr,0.9fr] lg:items-center">
            <div class="space-y-6">
                <span class="page-ribbon">Unidade verificada • {{ $vehicle->year }}</span>
                <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
                    {{ $vehicle->title }}
                </h1>
                <p class="text-sm text-slate-600">
                    {{ $vehicle->brand->name }} • {{ $vehicle->model->name }} • {{ $vehicle->color->name }} • {{ number_format($vehicle->mileage, 0, ',', '.') }} km
                </p>

                <div class="flex flex-wrap gap-4">
                    <div class="page-kpi">
                        <span class="page-kpi__value">{{ $vehicle->year }}</span>
                        <span>Ano modelo</span>
                    </div>
                    <div class="page-kpi">
                        <span class="page-kpi__value">{{ number_format($vehicle->mileage, 0, ',', '.') }}</span>
                        <span>km originais</span>
                    </div>
                    <div class="page-kpi">
                        <span class="page-kpi__value text-indigo-600">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</span>
                        <span>Valor a vista</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="mailto:contato@andrecarros.com?subject={{ rawurlencode('Quero negociar o '.$vehicle->title) }}" class="page-button">
                        negociar agora
                    </a>
                    <a href="{{ route('home') }}#estoque" class="page-button--ghost">
                        voltar ao catalogo
                    </a>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="page-chip page-chip--soft">Check-in digital</span>
                    <span class="page-chip page-chip--soft">Garantia 12 meses</span>
                    <span class="page-chip page-chip--soft">Entrega em casa</span>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-white/60 bg-white/70 shadow-xl backdrop-blur">
                <img
                    src="{{ $vehicle->main_photo_url }}"
                    alt="Foto principal do veiculo {{ $vehicle->title }}"
                    class="h-full w-full object-cover"
                >
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1.6fr,1fr]">
        <section class="space-y-8">
            @if ($vehicle->photos->count() > 1)
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($vehicle->photos->where('is_primary', false) as $photo)
                        <img
                            src="{{ $photo->url }}"
                            alt="Foto adicional do veiculo {{ $vehicle->title }}"
                            class="h-40 w-full rounded-xl border border-slate-200 object-cover"
                        >
                    @endforeach
                </div>
            @endif

            <article class="glass-card">
                <h2 class="text-xl font-semibold text-slate-900">Briefing completo</h2>
                <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">
                    {{ $vehicle->description }}
                </p>
            </article>

            <section class="grid gap-6 md:grid-cols-2">
                <div class="glass-card space-y-3">
                    <h3 class="text-lg font-semibold text-slate-900">Checklist digital</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li>• 120 itens verificados em scanner estrutural.</li>
                        <li>• Telemetria e histórico de revisões anexados ao dossiê.</li>
                        <li>• Sem apontamentos de sinistro ou leilão.</li>
                    </ul>
                </div>
                <div class="glass-card space-y-3">
                    <h3 class="text-lg font-semibold text-slate-900">Experiência híbrida</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li>• Test drive com acompanhamento por vídeo.</li>
                        <li>• Assinatura eletrônica integrada com Serasa.</li>
                        <li>• Entrega higienizada na sua casa em até 24h.</li>
                    </ul>
                </div>
            </section>
        </section>

        <aside class="space-y-6">
            <div class="glass-card">
                <h3 class="text-lg font-semibold text-slate-900">Resumo técnico</h3>
                <dl class="mt-4 space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between">
                        <dt>Marca</dt>
                        <dd class="font-semibold text-slate-900">{{ $vehicle->brand->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Modelo</dt>
                        <dd class="font-semibold text-slate-900">{{ $vehicle->model->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Cor</dt>
                        <dd class="font-semibold text-slate-900">{{ $vehicle->color->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Ano</dt>
                        <dd class="font-semibold text-slate-900">{{ $vehicle->year }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Quilometragem</dt>
                        <dd class="font-semibold text-slate-900">{{ number_format($vehicle->mileage, 0, ',', '.') }} km</dd>
                    </div>
                </dl>
            </div>

            <div class="glass-card space-y-4">
                <h3 class="text-lg font-semibold text-slate-900">Fale com a equipe</h3>
                <p class="text-sm text-slate-600">
                    Agende test drive, simule financiamento ou envie seu usado para avaliação digital.
                </p>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li><strong class="text-slate-900">Telefone:</strong> (11) 4000-2025</li>
                    <li><strong class="text-slate-900">WhatsApp:</strong> +55 11 98888-2025</li>
                </ul>
                <a href="mailto:contato@andrecarros.com" class="page-button w-full justify-center">
                    Quero negociar agora
                </a>
            </div>
        </aside>
    </div>

    @if ($relatedVehicles->isNotEmpty())
        <section class="mt-12 glass-card">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Curadoria personalizada</p>
                    <h2 class="text-lg font-semibold text-slate-900">Veja tambem</h2>
                    <p class="text-sm text-slate-500">Outras opcoes que seguem o mesmo padrao de qualidade.</p>
                </div>
                <a href="{{ route('home') }}#estoque" class="page-button--ghost">
                    ver catalogo completo
                </a>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                @foreach ($relatedVehicles as $related)
                    <a href="{{ route('vehicles.show', $related) }}" class="flex items-center gap-4 rounded-2xl border border-slate-200/70 bg-white/90 p-4 shadow-sm transition hover:border-indigo-400 hover:shadow-md">
                        <div class="h-20 w-28 overflow-hidden rounded-lg">
                            <img src="{{ $related->main_photo_url }}" alt="Foto de {{ $related->title }}" class="h-full w-full object-cover">
                        </div>
                        <div>
                            <p class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500">{{ $related->brand->name }}</p>
                            <h3 class="text-base font-semibold text-slate-900">{{ $related->title }}</h3>
                            <p class="text-sm text-slate-500">{{ $related->model->name }}</p>
                            <p class="mt-1 text-sm font-semibold text-indigo-600">R$ {{ number_format($related->price, 2, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
