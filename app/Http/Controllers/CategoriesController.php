<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\CategoriesModel;
use App\Services\CategoriesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    protected $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->wantsJson()) {
            $categories = CategoriesModel::all(['id', 'code', 'name']);
            return response()->json(['data' => $categories]);
        }

        return view('admin.categories.index');
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $result = $this->categoriesService->createCategory($request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dibuat']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal membuat kategori'], 500);
    }

    public function show($id): JsonResponse
    {
        $category = CategoriesModel::findOrFail($id);
        return response()->json($category);
    }

    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        $result = $this->categoriesService->updateCategory($id, $request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil diupdate']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal mengupdate kategori'], 500);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->categoriesService->deleteCategory($id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal menghapus kategori'], 500);
    }
}
