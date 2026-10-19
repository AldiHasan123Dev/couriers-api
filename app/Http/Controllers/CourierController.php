<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CourierController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
            'level' => ['nullable', 'string', 'max:20'],
            'sort' => ['nullable', Rule::in(['name', 'registered_at'])],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:100'],
        ]);
        $query = Courier::query();
        $search = trim($validated['search'] ?? '');

        if ($search !== '') {
            $keywords = preg_split('/\s+/', $search);

            foreach ($keywords as $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        }
        $levels = [];
        if (!empty($validated['level'])) {
            $levels = array_unique(array_map(
                'trim',
                explode(',', $validated['level'])
            ));
            $validLevels = ['1', '2', '3', '4', '5'];
            if (count(array_diff($levels, $validLevels)) > 0) {
                return back()
                    ->withErrors([
                        'level' => 'Filter level harus berisi angka 1 sampai 5.',
                    ])
                    ->withInput();
            }
            $query->whereIn('level', $levels);
        }

        $sort = $validated['sort'] ?? 'name';
        $direction = $validated['direction'] ?? 'asc';

        if ($sort === 'registered_at') {
            $query->orderBy('created_at', $direction);
        } else {
            $query->orderBy('name', $direction);
        }

        $query->orderBy('id', 'asc');
        $couriers = $query
            ->paginate($validated['per_page'] ?? 10)
            ->withQueryString();
        $statistics = [
            'total' => Courier::count(),
            'active' => Courier::where('is_active', true)->count(),
            'inactive' => Courier::where('is_active', false)->count(),
        ];

        return view('couriers.index', compact(
            'couriers',
            'statistics'
        ));
    }

    public function create(): View
    {
        return view('couriers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:couriers,email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'level' => ['required', 'integer', 'between:1,5'],
            'is_active' => ['required', 'boolean'],
        ]);

        Courier::create($validated);

        return redirect()
            ->route('couriers.index')
            ->with('success', 'Kurir berhasil ditambahkan.');
    }

    public function show(Courier $courier): View
    {
        return view('couriers.show', compact('courier'));
    }

    public function edit(Courier $courier): View
    {
        return view('couriers.edit', compact('courier'));
    }

    public function update(
        Request $request,
        Courier $courier
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('couriers', 'email')->ignore($courier->id),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'level' => ['required', 'integer', 'between:1,5'],
            'is_active' => ['required', 'boolean'],
        ]);

        $courier->update($validated);

        return redirect()
            ->route('couriers.index')
            ->with('success', 'Data kurir berhasil diperbarui.');
    }

    public function destroy(Courier $courier): RedirectResponse
    {
        $courier->delete();

        return redirect()
            ->route('couriers.index')
            ->with('success', 'Data kurir berhasil dihapus.');
    }
}