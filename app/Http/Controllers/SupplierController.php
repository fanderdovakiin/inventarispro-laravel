<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Daftar supplier dan pencarian.
     * Admin dan staff yang login boleh melihat data.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $suppliers = Supplier::query()
            ->withCount('products')
            ->when(
                !empty($validated['search']),
                function ($query) use ($validated) {
                    $search = $validated['search'];

                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('supplier_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                }
            )
            ->orderBy('supplier_name')
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'supplier_name' => [
                'required',
                'string',
                'max:150',
            ],
            'contact_info' => [
                'nullable',
                'string',
                'max:255',
            ],
            'location' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'email' => [
                'nullable',
                'email',
                'max:100',
                'unique:suppliers,email',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load([
            'products' => fn($query) => $query->orderBy('product_name'),
        ]);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $this->authorizeAdmin();

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'supplier_name' => [
                'required',
                'string',
                'max:150',
            ],
            'contact_info' => [
                'nullable',
                'string',
                'max:255',
            ],
            'location' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('suppliers', 'email')
                    ->ignore($supplier->supplier_id, 'supplier_id'),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $this->authorizeAdmin();

        /*
         * Foreign key pada database akan:
         * - Menghapus relasi product_suppliers yang terkait.
         * - Mengatur supplier_id pada histori stok menjadi NULL.
         * Histori transaksi tetap tersimpan.
         */
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil dihapus. Relasi terkait diperbarui sesuai aturan database.'
            );
    }

    private function authorizeAdmin(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Anda tidak memiliki izin untuk melakukan tindakan ini.'
        );
    }
}
