<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Daftar produk dengan pencarian, filter, sorting, dan pagination.
     * Staff dapat melihat produk, tetapi tidak mengubah data master.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'category_id'),
            ],
            'sort' => [
                'nullable',
                Rule::in([
                    'product_name',
                    'sku',
                    'price',
                    'stock',
                    'created_at',
                ]),
            ],
            'direction' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],
        ]);

        $sort = $filters['sort'] ?? 'product_name';
        $direction = $filters['direction'] ?? 'asc';

        $products = Product::query()
            ->with(['category', 'suppliers'])
            ->when(
                !empty($filters['search']),
                function ($query) use ($filters) {
                    $search = $filters['search'];

                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where(
                                'product_name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'sku',
                                'like',
                                "%{$search}%"
                            );
                    });
                }
            )
            ->when(
                !empty($filters['category_id']),
                fn($query) => $query->where(
                    'category_id',
                    $filters['category_id']
                )
            )
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('category_name')->get();

        return view('products.index', compact(
            'products',
            'categories',
            'sort',
            'direction'
        ));
    }

    /**
     * Form tambah produk. Khusus admin.
     */
    public function create()
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('category_name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Simpan produk baru.
     * Stok awal selalu 0 dan tidak diisi langsung melalui form.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'sku' => [
                'required',
                'string',
                'max:50',
                'unique:products,sku',
            ],
            'product_name' => [
                'required',
                'string',
                'max:150',
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'category_id'),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'expiry_date' => [
                'nullable',
                'date',
            ],
        ]);

        $validated['stock'] = 0;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan dengan stok awal 0.'
            );
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('category_name')->get();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Perbarui informasi produk tanpa mengubah stok.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'sku')
                    ->ignore($product->product_id, 'product_id'),
            ],
            'product_name' => [
                'required',
                'string',
                'max:150',
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'category_id'),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'expiry_date' => [
                'nullable',
                'date',
            ],
        ]);

        // Stok tidak boleh diubah melalui form edit produk.
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Informasi produk berhasil diperbarui.');
    }

    /**
     * Hapus produk yang belum memiliki histori transaksi stok.
     */
    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

        if ($product->stockMovements()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena memiliki histori transaksi stok.'
                );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Batasi perubahan data produk untuk admin.
     */
    private function authorizeAdmin(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Anda tidak memiliki izin untuk melakukan tindakan ini.'
        );
    }
}
