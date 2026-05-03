@extends('layouts.admin')

@section('title', 'Daftar Tech Stack')
@section('page-title', 'Manajemen Tech Stack')

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
                Daftar Tech Stack Sistem
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Tech Stack
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
                        @forelse($techStacks as $techStack)
                            <tr>
                                <td>{{ $techStack->id }}</td>
                                <td>{{ $techStack->code }}</td>
                                <td>{{ $techStack->name }}</td>
                                <td>
                                    <!-- Button trigger Edit Modal -->
                                        <button type="button" class="btn btn-info text-white btn-sm edit-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            data-id="{{ $techStack->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="{{ $techStack->id }}"
                                            data-name="{{ $techStack->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data tech stack</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @include('admin.tech-stacks.create')
    @include('admin.tech-stacks.update')
    @include('admin.tech-stacks.delete')

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
                    const errorSpan = form.querySelector('#error-' + field) || form.querySelector('#error-edit-' + field);
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
            const createForm = document.getElementById('createTechStackForm');
            handleAjaxSubmit(createForm, '#createSubmitBtn', '#createFormAlert', 'Simpan Tech Stack');

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
                    
                    document.getElementById('deleteTechStackName').textContent = name;
                    document.getElementById('deleteTechStackForm').action = `/admin/tech-stacks/${id}`;
                });
            });
            
            // Handle Edit Modal Binding (AJAX Fetch)
            const editForm = document.getElementById('editTechStackForm');
            const editCodeInput = document.getElementById('editTechStackCode');
            const editNameInput = document.getElementById('editTechStackName');
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
                    fetch(`/admin/tech-stacks/${id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        editCodeInput.value = data.code;
                        editNameInput.value = data.name;
                        editForm.action = `/admin/tech-stacks/${id}`;
                        
                        editSubmitBtn.disabled = false;
                        editSubmitBtn.textContent = 'Simpan Perubahan';
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        editAlert.classList.remove('d-none');
                        editAlert.textContent = 'Gagal memuat data tech stack.';
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
