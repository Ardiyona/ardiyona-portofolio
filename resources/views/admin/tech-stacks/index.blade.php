@extends('layouts.admin')

@section('title', 'Daftar Tech Stack')
@section('page-title', 'Manajemen Tech Stack')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                Daftar Tech Stack Sistem
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Tech Stack
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="techStacksTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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

            // ===== Toast Notification =====
            function showToast(message, type = 'success') {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: 'top',
                    position: 'right',
                    style: {
                        background: type === 'success'
                            ? 'linear-gradient(to right, #00b09b, #96c93d)'
                            : 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    }
                }).showToast();
            }

            const table = $('#techStacksTable').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.tech-stacks.list') }}',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'code' },
                    { data: 'name' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            return `
                                <button type="button" class="btn btn-info text-white btn-sm edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </button>
                            `;
                        }
                    }
                ],
                language: {
                    emptyTable: 'Tidak ada data kategori',
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                    paginate: { previous: 'Sebelumnya', next: 'Selanjutnya' }
                }
            });

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

            function handleAjaxSubmit(form, submitBtnSelector, alertSelector, originalBtnText, modalId) {
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
                            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                            if (modal) modal.hide();
                            form.reset();
                            table.ajax.reload(null, false);
                            showToast(data.message);
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
            handleAjaxSubmit(createForm, '#createSubmitBtn', '#createFormAlert', 'Simpan Tech Stack', 'createModal');

            document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
                const modal = document.getElementById('createModal');
                const alertEl = document.getElementById('createFormAlert');
                clearFormErrors(modal, alertEl);
                createForm.reset();
            });

            // ===== Dynamic Modals (Edit & Delete) =====
            
            // Handle Delete Modal Binding
            $('#techStacksTable').on('click', '.delete-btn', function () {
                const rowData = table.row($(this).closest('tr')).data();

                document.getElementById('deleteTechStackName').textContent = rowData.name;
                document.getElementById('deleteTechStackForm').action = `/admin/tech-stacks/${rowData.id}`
            });

            const deleteForm = document.getElementById('deleteTechStackForm');
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch(deleteForm.action, {
                    method: 'POST',
                    header: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new FormData(deleteForm)
                })
                .then(async response => {
                    const data = await response.json();
                    console.log(data);
                    if (!response.ok) throw { status: response.status, data: data };
                    return data;
                })
                .then(data => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    if (modal) modal.hide();
                    table.ajax.reload(null, false);
                    showToast(data.message);
                })
                .catch(err => {
                    showToast(err.data?.message || 'Gagal menghapus tech stack', 'error');
                });
            });
            
            // Handle Edit Modal Binding (AJAX Fetch)
            const editForm = document.getElementById('editTechStackForm');
            const editCodeInput = document.getElementById('editTechStackCode');
            const editNameInput = document.getElementById('editTechStackName');
            const editAlert = document.getElementById('editFormAlert');
            const editSubmitBtn = document.getElementById('editSubmitBtn');
            
            handleAjaxSubmit(editForm, '#editSubmitBtn', '#editFormAlert', 'Simpan Perubahan', 'editModal');

            $('#techStacksTable').on('click', '.edit-btn', function () {
                const id = table.row($(this).closest('tr')).data().id;
                
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

            document.getElementById('editModal').addEventListener('hidden.bs.modal', function () {
                clearFormErrors(editForm, editAlert);
            });

        });
    </script>
@endpush
