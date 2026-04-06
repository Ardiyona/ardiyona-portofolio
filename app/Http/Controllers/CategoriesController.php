<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\CategoriesModel;
use App\Services\CategoriesService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function index()
    {
        $categories = CategoriesModel::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        $result = $this->categoriesService->createCategory($request->all());

        if ($request->ajax() || $request->wantsJson()) {
            if ($result['status']) {
                session()->flash('success', 'Kategori berhasil dibuat');
                return response()->json(['success' => true, 'message' => 'Kategori berhasil dibuat']);
            }
            return response()->json(['message' => $result['message'] ?? 'Gagal membuat kategori'], 500);
        }
    }

    public function show($id)
    {
        $category = CategoriesModel::findOrFail($id);
        return response()->json($category);
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $result = $this->categoriesService->updateCategory($id, $request->all());

        if ($request->ajax() || $request->wantsJson()) {
            if ($result['status']) {
                session()->flash('success', 'Kategori berhasil diupdate');
                return response()->json(['success' => true, 'message' => 'Kategori berhasil diupdate']);
            }
            return response()->json(['message' => $result['message'] ?? 'Gagal mengupdate kategori'], 500);
        }
    }

    public function destroy($id)
    {
        $result = $this->categoriesService->deleteCategory($id);

        if ($result['status']) {
            session()->flash('success', 'Kategori berhasil dihapus');
            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        }
        return redirect()->route('admin.categories.index')->with('error', 'Kategori gagal dihapus.');
    }
}
