<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductVariantController extends Controller
{
    public function index()
    {
        /* $productVariants = ProductVariant::with('product.translations', 'translations')
         ->paginate(10);

         $languages = Language::active()->get();

         return view('admin.product_variants.index', compact('productVariants', 'languages')); */

        $languages = Language::active()->get(); // Get active languages

        return view('admin.product_variants.index', compact('languages'));
    }

    public function getData(Request $request)
    {
        $productVariants = ProductVariant::with('product', 'translations')
            ->select('product_variants.*'); // Use select to avoid eager loading too much data

        return DataTables::of($productVariants)
            ->addColumn('id', function ($productVariant) {
                return $productVariant->id;  // Add the ID here
            })
            ->addColumn('product', function ($productVariant) {
                return $productVariant->product->translations->first()->name ?? 'Unknown Product';
            })
            ->addColumn('variant_name', function ($productVariant) {
                return $productVariant->translations->first()->name ?? 'N/A';
            })
            ->addColumn('action', function ($productVariant) {
                return '<a href="'.route('admin.product_variants.edit', $productVariant->id).'" class="btn btn-warning btn-sm">Edit</a>
                    <form action="'.route('admin.product_variants.destroy', $productVariant->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this variant?\');">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $products = Product::where('status', 1)
            ->with(['translations' => function ($query) {
                $query->where('language_code', app()->getLocale());
            }])
            ->get();

        $languages = Language::active()->get();

        return view('admin.product_variants.create', compact('products', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.value' => 'nullable|string|max:255',
        ]);

        $translations = $request->input('translations');
        $productVariantData = $request->except('translations');

        $productVariantData['variant_slug'] = Str::slug($request->input('name'));

        $productVariant = ProductVariant::create($productVariantData);

        foreach ($translations as $locale => $translation) {
            $productVariant->translations()->create([
                'locale' => $locale,
                'name' => $translation['name'],
                'value' => $translation['value'] ?? null,
            ]);
        }

        return redirect()->route('admin.product_variants.index')->with('success', 'Product Variant created successfully.');
    }

    public function edit($id)
    {
        $productVariant = ProductVariant::with('translations')->findOrFail($id);

        $products = Product::where('status', 1)
            ->with(['translations' => function ($query) {
                $query->where('language_code', app()->getLocale());
            }])
            ->get();

        $languages = Language::active()->get();

        return view('admin.product_variants.edit', compact('productVariant', 'products', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'variant_slug' => 'required|unique:product_variants,variant_slug,'.$id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.value' => 'nullable|string|max:255',
        ]);

        $translations = $request->input('translations');
        $productVariantData = $request->except('translations');

        $productVariantData['variant_slug'] = Str::slug($request->input('name'));

        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->update($productVariantData);

        foreach ($translations as $locale => $translation) {
            $productVariant->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name' => $translation['name'],
                    'value' => $translation['value'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.product_variants.index')->with('success', 'Product Variant updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $productVariant = ProductVariant::findOrFail($id);
            $productVariant->translations()->delete();
            $productVariant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product Variant deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the product variant.',
            ]);
        }
    }
}
