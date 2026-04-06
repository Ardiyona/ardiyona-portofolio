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
                                        <button type="button" class="btn btn-info text-white btn-sm edit-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            data-id="{{ $category->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                </td>
                            </tr>

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

    @include('admin.categories.create')
    @include('admin.categories.update')
    @include('admin.categories.delete')

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

            // ===== Dynamic Modals (Edit & Delete) =====
            
            // Handle Delete Modal Binding
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    
                    document.getElementById('deleteCategoryName').textContent = name;
                    document.getElementById('deleteCategoryForm').action = `/admin/categories/${id}`;
                });
            });
            
            // Handle Edit Modal Binding (AJAX Fetch)
            const editForm = document.getElementById('editCategoryForm');
            const editCodeInput = document.getElementById('editCategoryCode');
            const editNameInput = document.getElementById('editCategoryName');
            const editAlert = document.getElementById('editFormAlert');
            const editSubmitBtn = document.getElementById('editSubmitBtn');
            
            handleAjaxSubmit(editForm, '#editSubmitBtn', '#editFormAlert', 'Simpan Perubahan');

            document.querySelectorAll('.edit-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    
                    // Reset form and errors
                    clearFormErrors(editForm, editAlert);
                    editForm.reset();
                    editSubmitBtn.disabled = true;
                    editSubmitBtn.textContent = 'Memuat...';
                    
                    // Fetch data
                    fetch(`/admin/categories/${id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        editCodeInput.value = data.code;
                        editNameInput.value = data.name;
                        editForm.action = `/admin/categories/${id}`;
                        
                        editSubmitBtn.disabled = false;
                        editSubmitBtn.textContent = 'Simpan Perubahan';
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        editAlert.classList.remove('d-none');
                        editAlert.textContent = 'Gagal memuat data kategori.';
                        editSubmitBtn.disabled = false;
                        editSubmitBtn.textContent = 'Simpan Perubahan';
                    });
                });
            });

            document.getElementById('editModal').addEventListener('hidden.bs.modal', function () {
                clearFormErrors(editForm, editAlert);
            });

        });
    </script>
@endpush