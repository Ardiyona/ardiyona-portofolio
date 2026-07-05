<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\CategoryModel;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): View
    {
        return view('admin.categories.index');
    }

    public function list(Request $request)
    {
        return DataTables::of(CategoryModel::select('id','name','code'))->make();
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $result = $this->categoryService->createCategory($request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dibuat']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal membuat kategori'], 500);
    }

    public function show($id): JsonResponse
    {
        $category = CategoryModel::findOrFail($id);
        return response()->json($category);
    }

    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        $result = $this->categoryService->updateCategory($id, $request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil diupdate']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal mengupdate kategori'], 500);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->categoryService->deleteCategory($id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal menghapus kategori'], 500);
    }
}
