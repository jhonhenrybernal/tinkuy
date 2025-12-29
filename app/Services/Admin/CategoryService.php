<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoriesForDataTable($request)
    {
        $categories = $this->categoryRepository->all()->load('translations');

        return DataTables::of($categories)
            ->addColumn('name', function ($category) {
                $translation = $category->translations->firstWhere('language_code', 'en');

                return $translation ? $translation->name : 'No name available';
            })
            ->addColumn('description', function ($category) {
                $translation = $category->translations->firstWhere('language_code', 'en');

                return $translation ? $translation->description : 'No description available';
            })
            ->addColumn('action', function ($category) {
                return '
                <a href="'.route('admin.categories.edit', $category->id).'" class="btn btn-primary btn-sm">Edit</a>
                <form action="'.route('admin.categories.destroy', $category->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this category?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created category.
     */
    public function store(array $translations)
    {
        $validator = Validator::make($translations, [
            '*.name' => 'required|string|max:255',
            '*.description' => 'nullable|string',
            '*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000', // Validate image
        ], trans('category'));

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $this->categoryRepository->storeWithTranslations($translations);
    }

    /**
     * Uploads an image and returns the full storage URL.
     */
    private function uploadImage($image)
    {
        $fileName = time().'_'.$image->getClientOriginalName();
        $path = $image->storeAs('categories', $fileName, 'public');

        return 'storage/'.$path; // Ensure it's publicly accessible
    }

    /**
     * Update an existing category.
     */
    public function update($request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000', // Validate image
        ]);

        return $this->categoryRepository->updateWithTranslations($category, $request->translations);
    }

    /**
     * Delete an existing category.
     */
    public function destroy($id)
    {
        // Call the repository to delete the category
        return $this->categoryRepository->destroy($id);
    }

    /**
     * Find a category by its ID.
     */
    public function find($id)
    {
        // Call the repository to find the category by ID
        return $this->categoryRepository->find($id);
    }
}
