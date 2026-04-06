@extends('layouts.admin')

@section('title', 'Daftar Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<section class="section">
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            Daftar Pengguna Sistem
            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-circle"></i> Tambah Pengguna
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <!-- Button trigger Edit Modal -->
                            <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Button trigger Delete Modal -->
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade text-left" id="editModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="editModalLabel{{ $user->id }}">Edit Pengguna</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form class="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="alert alert-danger d-none edit-form-alert"></div>
                                        <label>Nama: </label>
                                        <div class="form-group">
                                            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                            <span class="text-danger small error-name"></span>
                                        </div>
                                        <label>Email: </label>
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                            <span class="text-danger small error-email"></span>
                                        </div>
                                        <label>Password (Kosongkan jika tidak ingin mengubah): </label>
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password (Min. 8 karakter)" class="form-control">
                                            <span class="text-danger small error-password"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary ms-1 edit-submit-btn">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade text-left" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="deleteModalLabel{{ $user->id }}">Konfirmasi Hapus</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus pengguna <strong>{{ $user->name }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger ms-1">Hapus Pengguna</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Create Modal -->
<div class="modal fade text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel">Tambah Pengguna Baru</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="createFormAlert"></div>
                    <label>Nama: </label>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Lengkap" class="form-control">
                        <span class="text-danger small" id="error-name"></span>
                    </div>
                    <label>Email: </label>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Aktif" class="form-control">
                        <span class="text-danger small" id="error-email"></span>
                    </div>
                    <label>Password: </label>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Minimal 8 Karakter" class="form-control">
                        <span class="text-danger small" id="error-password"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1" id="createSubmitBtn">Simpan Pengguna</button>
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
        const createForm = document.getElementById('createUserForm');
        handleAjaxSubmit(createForm, '#createSubmitBtn', '#createFormAlert', 'Simpan Pengguna');

        document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
            const modal = document.getElementById('createModal');
            const alertEl = document.getElementById('createFormAlert');
            clearFormErrors(modal, alertEl);
            createForm.reset();
        });

        // ===== Edit Modals =====
        document.querySelectorAll('.editUserForm').forEach(function (editForm) {
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
