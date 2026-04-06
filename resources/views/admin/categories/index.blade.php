@extends('layouts.admin')

@section('title', 'Daftar Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
    <section class="section">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Ada kesalahan input, silakan periksa kembali form Anda.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                Daftar Kategori Sistem
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->code }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <!-- Button trigger Edit Modal -->
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $category->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!-- Button trigger Delete Modal -->
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $category->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            {{-- <div class="modal fade text-left" id="editModal{{ $category->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Kategori</h4>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <label>Kode: </label>
                                                <div class="form-group">
                                                    <input type="code" name="code" value="{{ old('code', $category->code) }}"
                                                        class="form-control" required>
                                                </div>
                                                <label>Nama: </label>
                                                <div class="form-group">
                                                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary ms-1">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Delete Modal -->
                            {{-- <div class="modal fade text-left" id="deleteModal{{ $category->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="deleteModalLabel{{ $category->id }}">Konfirmasi Hapus
                                            </h4>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus kategori <strong>{{ $category->name
                                                        }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger ms-1">Hapus Kategori</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}

                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Create Modal -->
    <div class="modal fade text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Kategori Baru</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label>Kode: </label>
                        <div class="form-group">
                            <input type="code" name="code" value="{{ old('code') }}" placeholder="Kode" class="form-control"
                                required>
                        </div>
                        <label>Nama: </label>
                        <div class="form-group">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary ms-1">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection