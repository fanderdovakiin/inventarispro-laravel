<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where('category_name', 'like', "%{$search}%");
            })
            ->orderBy('category_name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,category_name',
            ],
            'description' => ['nullable', 'string'],
        ]);

        $slug = $this->makeUniqueSlug($validated['category_name']);

        Category::create([
            'category_name' => $validated['category_name'],
            'description' => $validated['description'] ?? null,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $this->authorizeAdmin();

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'category_name')
                    ->ignore($category->category_id, 'category_id'),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $slug = $this->makeUniqueSlug(
            $validated['category_name'],
            $category->category_id
        );

        $category->update([
            'category_name' => $validated['category_name'],
            'description' => $validated['description'] ?? null,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeAdmin();

        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih memiliki produk.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Pastikan hanya admin yang dapat mengubah data kategori.
     */
    private function authorizeAdmin(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Anda tidak memiliki izin untuk melakukan tindakan ini.'
        );
    }

    /**
     * Menghasilkan slug unik untuk URL kategori.
     */
    private function makeUniqueSlug(
        string $categoryName,
        ?int $ignoreCategoryId = null
    ): string {
        $baseSlug = Str::slug($categoryName);

        if ($baseSlug === '') {
            $baseSlug = 'kategori';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Category::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreCategoryId !== null,
                    fn($query) => $query->where(
                        'category_id',
                        '!=',
                        $ignoreCategoryId
                    )
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
