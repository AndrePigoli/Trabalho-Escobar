<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Marcas cadastradas</h1>
            <a href="{{ route('admin.brands.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                Nova marca
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.status')

            <div class="overflow-hidden rounded-2xl bg-white shadow ring-1 ring-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm leading-6">
                    <thead class="bg-gray-50 text-left font-semibold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nome</th>
                            <th scope="col" class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($brands as $brand)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $brand->name }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="rounded-lg border border-indigo-200 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-600 transition hover:border-indigo-400 hover:text-indigo-700">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta marca?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-rose-600 transition hover:border-rose-400 hover:text-rose-700">
                                                Remover
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-6 text-center text-gray-500">
                                    Nenhuma marca cadastrada no momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $brands->links() }}
        </div>
    </div>
</x-app-layout>
