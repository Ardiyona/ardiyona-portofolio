<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
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

    public function store(CategoriesRequest $request)
    {
        $result = $this->categoriesService->createCategory($request->all());
        if ($result['status']) {
            return redirect()->back()->with('success', 'Kategori berhasil dibuat');
        }
        return redirect()->back()->with('error', $result['message'] ?? 'Gagal membuat kategori')->withInput();
    }
}
