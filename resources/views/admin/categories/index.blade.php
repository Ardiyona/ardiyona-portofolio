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
                            <div class="modal fade text-left" id="editModal{{ $category->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Kategori</h4>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <form class="editCategoryForm"
                                            action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="alert alert-danger d-none edit-form-alert"></div>
                                                <label>Kode: </label>
                                                <div class="form-group">
                                                    <input type="code" name="code" value="{{ old('code', $category->code) }}"
                                                        class="form-control">
                                                    <span class="text-danger small error-code"></span>
                                                </div>
                                                <label>Nama: </label>
                                                <div class="form-group">
                                                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                                        class="form-control">
                                                    <span class="text-danger small error-name"></span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary ms-1 edit-submit-btn">Simpan
                                                    Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade text-left" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
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
                            </div>

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
                <form id="createCategoryForm" action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="createFormAlert"></div>
                        <label>Kode: </label>
                        <div class="form-group">
                            <input type="text" name="code" placeholder="Kode" class="form-control">
                            <span class="text-danger small" id="error-code"></span>
                        </div>
                        <label>Nama: </label>
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Nama Lengkap" class="form-control">
                            <span class="text-danger small" id="error-name"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary ms-1" id="createSubmitBtn">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ===== Helper Functions =====
            function clearFormErrors(form, alertEl) {
                form.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                if (alertEl) {
                    alertEl.classList.add('d-none');
                    alertEl.textContent = '';
                }
            }

            function showValidationErrors(form, alertEl, errors) {
                for (const field in errors) {
                    const errorSpan = form.querySelector('#error-' + field) || form.querySelector('.error-' + field);
                    const input = form.querySelector('[name="' + field + '"]');
                    if (errorSpan) {
                        errorSpan.textContent = errors[field][0];
                    }
                    if (input) {
                        input.classList.add('is-invalid');
                    }
                }
            }

            function handleAjaxSubmit(form, submitBtnSelector, alertSelector, originalBtnText) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Find elements lazily from the closest modal or form itself
                    const container = form.closest('.modal') || form;
                    const submitBtn = container.querySelector(submitBtnSelector);
                    const alertEl = container.querySelector(alertSelector);

                    clearFormErrors(container, alertEl);

                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    }

                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                        .then(async response => {
                            const data = await response.json();
                            if (!response.ok) {
                                throw { status: response.status, data: data };
                            }
                            return data;
                        })
                        .then(data => {
                            window.location.reload();
                        })
                        .catch(err => {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;
                            }

                            if (err.status === 422 && err.data.errors) {
                                showValidationErrors(container, alertEl, err.data.errors);
                            } else if (alertEl) {
                                alertEl.classList.remove('d-none');
                                alertEl.textContent = err.data?.message || 'Terjadi kesalahan, silakan coba lagi.';
                            }
                        });
                });
            }

            // ===== Create Modal =====
            const createForm = document.getElementById('createCategoryForm');
            handleAjaxSubmit(createForm, '#createSubmitBtn', '#createFormAlert', 'Simpan Kategori');

            document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
                const modal = document.getElementById('createModal');
                const alertEl = document.getElementById('createFormAlert');
                clearFormErrors(modal, alertEl);
                createForm.reset();
            });

            // ===== Edit Modals =====
            document.querySelectorAll('.editCategoryForm').forEach(function (editForm) {
                handleAjaxSubmit(editForm, '.edit-submit-btn', '.edit-form-alert', 'Simpan Perubahan');

                const modal = editForm.closest('.modal');
                if (modal) {
                    modal.addEventListener('hidden.bs.modal', function () {
                        const alertEl = modal.querySelector('.edit-form-alert');
                        clearFormErrors(modal, alertEl);
                    });
                }
            });

        });
    </script>
@endpush