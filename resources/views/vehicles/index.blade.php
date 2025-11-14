@php
    use Illuminate\Support\Str;

    $vehicles = $catalog->vehicles();
    $stats = $catalog->stats();
    $recentActivity = $catalog->recentActivity();
@endphp

@extends('layouts.public')

@section('title', 'Catalogo de veiculos | andreCarros')

@section('hero')
    <section class="page-hero">
        <div class="page-hero__grid">
            <div class="space-y-6">
                <span class="page-ribbon">
                    Atualizacao 2025
                    <span class="rounded-full bg-indigo-600 px-2 py-0.5 text-white">Nova curadoria</span>
                </span>
                <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl">
                    Seminovos com laudos digitais, assinatura eletrônica e entrega expressa.
                </h1>
                <p class="max-w-xl text-sm text-slate-600">
                    Cada carro passa por 120 itens de inspeção, possui dossiê completo e pode ser reservado online.
                    Nossa equipe acompanha por vídeo chamada todo o processo para garantir transparência total.
                </p>

                <div class="flex flex-wrap gap-4">
                    <div class="page-kpi">
                        <span class="page-kpi__value">{{ number_format($stats['total'], 0, ',', '.') }}</span>
                        <span>veiculos ativos</span>
                    </div>
                    <div class="page-kpi">
                        <span class="page-kpi__value">{{ $stats['brands'] }}</span>
                        <span>marcas premium</span>
                    </div>
                    <div class="page-kpi">
                        <span class="page-kpi__value">{{ $stats['newest_year'] }}</span>
                        <span>ano mais novo</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="#estoque" class="page-button">
                        Ver estoque completo
                    </a>
                    <a href="mailto:contato@andrecarros.com?subject=Quero%20agendar%20um%20video%20tour" class="page-button--ghost">
                        Agendar video tour
                    </a>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="page-chip page-chip--soft">Documentacao em 24h</span>
                    <span class="page-chip page-chip--soft">Laudo aprovado</span>
                    <span class="page-chip page-chip--soft">Entrega em casa</span>
                </div>
            </div>

            <div class="glass-card space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Ultimas reservas digitais</p>
                        <p class="text-2xl font-semibold text-slate-900 mt-2">3 carros saíram hoje</p>
                    </div>
                    <span class="page-chip">
                        Live
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    </span>
                </div>

                <ul class="space-y-4 text-sm text-slate-600">
                    @forelse ($recentActivity as $activity)
                        <li class="flex items-center justify-between">
                            <span>{{ $activity->title }}</span>
                            <span class="font-semibold text-slate-900">{{ $activity->updated_at->diffForHumans(null, true) }} atrás</span>
                        </li>
                    @empty
                        <li class="text-slate-500">Monitorando atualizações do estoque...</li>
                    @endforelse
                </ul>

                <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-4 text-sm text-slate-600">
                    Atendimento prioritário para trocas com avaliação 100% digital. Envie fotos e laudo via WhatsApp e
                    receba a proposta em até 30 minutos úteis.
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section id="estoque" class="page-section">
        <div class="flex flex-wrap items-center justify-between gap-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
            <span>Filtros curados pela equipe andreCarros</span>
            <div class="flex flex-wrap gap-2">
                <span class="page-pill">Laudo aprovado</span>
                <span class="page-pill">Garantia exclusiva</span>
                <span class="page-pill">Pronto para entrega</span>
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($vehicles as $vehicle)
                <article class="page-card">
                    <a href="{{ route('vehicles.show', $vehicle) }}" class="page-card__media block">
                        <img
                            src="{{ $vehicle->main_photo_url }}"
                            alt="Foto de {{ $vehicle->title }}"
                            loading="lazy"
                        >
                        <span class="page-card__media-badge">
                            {{ $vehicle->year }} • {{ strtoupper(Str::substr($vehicle->color->name, 0, 3)) }}
                        </span>
                    </a>

                    <div class="page-card__body">
                        <div class="space-y-1">
                            <p class="text-[0.65rem] uppercase tracking-[0.3em] text-slate-500">{{ $vehicle->brand->name }}</p>
                            <h2 class="text-xl font-semibold text-slate-900">
                                <a href="{{ route('vehicles.show', $vehicle) }}">{{ $vehicle->title }}</a>
                            </h2>
                            <p class="text-sm text-slate-500">{{ $vehicle->model->name }} | {{ $vehicle->color->name }}</p>
                        </div>

                        <div class="page-divider"></div>

                        <dl class="grid grid-cols-3 gap-4 text-xs uppercase tracking-[0.25em] text-slate-500">
                            <div>
                                <dt class="text-[0.6rem] text-slate-400">Ano</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $vehicle->year }}</dd>
                            </div>
                            <div>
                                <dt class="text-[0.6rem] text-slate-400">KM</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ number_format($vehicle->mileage, 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-[0.6rem] text-slate-400">Valor</dt>
                                <dd class="mt-1 text-sm font-semibold text-indigo-600">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <p class="line-clamp-3 text-sm text-slate-500">
                            {{ $vehicle->description }}
                        </p>
                    </div>

                    <div class="page-card__footer">
                        <span>Ver detalhes</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </article>
            @empty
                <div class="page-card col-span-full items-center justify-center px-8 py-16 text-center">
                    <h3 class="text-xl font-semibold text-slate-900">Nenhum veiculo disponivel no momento.</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Atualizamos o estoque frequentemente. Fale com a equipe para ser avisado das proximas oportunidades.
                    </p>
                    <div class="mt-4 flex justify-center">
                        <a href="mailto:contato@andrecarros.com" class="page-button--ghost">
                            Quero ser avisado
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="flex justify-center">
            {{ $vehicles->links('components.pagination.front') }}
        </div>
    </section>

    <section id="diferenciais" class="page-section">
        <div class="rounded-3xl border border-slate-200 bg-white/90 p-10 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="page-ribbon">Manifesto andreCarros</p>
                    <h2 class="mt-4 text-2xl font-semibold text-slate-900">Curadoria humana com tecnologia de ponta.</h2>
                    <p class="mt-2 text-sm text-slate-500">Do primeiro contato à assinatura digital, tudo acontece em menos de 48h.</p>
                </div>
                <a href="#contato" class="page-button">
                    falar com especialista
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="glass-card space-y-3">
                    <h3 class="text-lg font-semibold text-slate-900">Dossiê completo</h3>
                    <p class="text-sm text-slate-600">Fotos em 8K, scanner estrutural, telemetria e histórico de revisões armazenados na nuvem.</p>
                </div>
                <div class="glass-card space-y-3">
                    <h3 class="text-lg font-semibold text-slate-900">Entrega expressa</h3>
                    <p class="text-sm text-slate-600">Logística própria para levar o carro higienizado até sua casa com assinatura eletrônica.</p>
                </div>
                <div class="glass-card space-y-3">
                    <h3 class="text-lg font-semibold text-slate-900">Troca transparente</h3>
                    <p class="text-sm text-slate-600">Avaliação do usado totalmente digital e proposta em até 30 minutos úteis.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contato" class="page-section">
        <div class="glass-card flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Central andreCarros</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Pronto para acelerar o próximo carro?</h2>
                <p class="mt-2 text-sm text-slate-600">Agende um atendimento híbrido: começamos online e terminamos com a entrega na sua casa.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="tel:+551140002025" class="page-button--ghost">Ligar agora</a>
                <a href="https://wa.me/5511988882025" class="page-button">WhatsApp</a>
            </div>
        </div>
    </section>
@endsection
