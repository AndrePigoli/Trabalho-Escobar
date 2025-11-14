<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(): View
    {
        $colors = Color::orderBy('name')->paginate(10);

        return view('admin.colors.index', compact('colors'));
    }

    public function create(): View
    {
        return view('admin.colors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:colors,name'],
            'hex_code' => ['nullable', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
        ]);

        Color::create($validated);

        return redirect()
            ->route('admin.colors.index')
            ->with('status', 'Cor cadastrada com sucesso.');
    }

    public function edit(Color $color): View
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:colors,name,'.$color->id],
            'hex_code' => ['nullable', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
        ]);

        $color->update($validated);

        return redirect()
            ->route('admin.colors.index')
            ->with('status', 'Cor atualizada com sucesso.');
    }

    public function destroy(Color $color): RedirectResponse
    {
        $color->delete();

        return redirect()
            ->route('admin.colors.index')
            ->with('status', 'Cor removida.');
    }
}
