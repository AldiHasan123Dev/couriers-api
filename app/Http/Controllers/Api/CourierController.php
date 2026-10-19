<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    /**
     * GET /api/couriers
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['sometimes', 'nullable', 'string', 'max:150'],
            'level' => ['sometimes', 'nullable', 'string', 'max:20'],
            'sort' => [
                'sometimes',
                Rule::in(['name', 'registered_at']),
            ],
            'direction' => [
                'sometimes',
                Rule::in(['asc', 'desc']),
            ],
            'per_page' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $query = Courier::query();

        // Pencarian multi-kata:
        // "budi agung" dapat menemukan "Budiono Hadi Agung".
        $search = trim($validated['search'] ?? '');

        if ($search !== '') {
            $keywords = preg_split('/\s+/', $search);

            foreach ($keywords as $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        }

        // Filter satu atau beberapa level, misalnya ?level=2,3
        if (!empty($validated['level'])) {
            $levels = explode(',', $validated['level']);

            $levels = array_map(
                'trim',
                $levels
            );

            $levels = array_unique($levels);

            $validLevels = array_filter(
                $levels,
                fn ($level) => in_array($level, ['1', '2', '3', '4', '5'], true)
            );

            if (count($validLevels) !== count($levels)) {
                return response()->json([
                    'message' => 'Level harus berupa angka 1 sampai 5.',
                    'errors' => [
                        'level' => ['Gunakan level 1, 2, 3, 4, atau 5.'],
                    ],
                ], 422);
            }

            $query->whereIn('level', $validLevels);
        }

        // Default: nama kurir A-Z.
        // Override: sort=registered_at untuk tanggal pendaftaran.
        $sort = $validated['sort'] ?? 'name';
        $direction = $validated['direction'] ?? 'asc';

        if ($sort === 'registered_at') {
            $query->orderBy('created_at', $direction);
        } else {
            $query->orderBy('name', $direction);
        }

        // ID menjadi urutan sekunder agar hasil stabil.
        $query->orderBy('id', 'asc');

        $couriers = $query->paginate(
            $validated['per_page'] ?? 10
        )->withQueryString();

        return response()->json($couriers);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:couriers,email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'level' => ['required', 'integer', 'between:1,5'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $courier = Courier::create($validated);

        return response()->json([
            'message' => 'Kurir berhasil ditambahkan.',
            'data' => $courier,
        ], 201);
    }
    public function show(Courier $courier)
    {
        return response()->json([
            'data' => $courier,
        ]);
    }

    /**
     * PUT/PATCH /api/couriers/{courier}
     */
    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:150'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:150',
                Rule::unique('couriers', 'email')->ignore($courier->id),
            ],
            'phone' => ['sometimes', 'required', 'string', 'max:20'],
            'address' => ['sometimes', 'nullable', 'string'],
            'level' => ['sometimes', 'required', 'integer', 'between:1,5'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $courier->update($validated);

        return response()->json([
            'message' => 'Data kurir berhasil diperbarui.',
            'data' => $courier->fresh(),
        ]);
    }

    /**
     * DELETE /api/couriers/{courier}
     */
    public function destroy(Courier $courier)
    {
        $courier->delete();

        return response()->json([
            'message' => 'Data kurir berhasil dihapus.',
        ]);
    }
}