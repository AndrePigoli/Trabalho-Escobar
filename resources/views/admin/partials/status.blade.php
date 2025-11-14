@if (session('status'))
    <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm font-medium text-emerald-700 ring-1 ring-emerald-100">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-lg bg-rose-50 p-4 text-sm text-rose-700 ring-1 ring-rose-100">
        <p class="font-semibold">Por favor, corrija os itens abaixo:</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
