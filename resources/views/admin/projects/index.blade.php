@extends('layouts.admin')

@section('title', 'Daftar Project')
@section('page-title', 'Manajemen Project')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                Daftar Project
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Project
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="projectsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tech Stack</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

    @include('admin.projects.create')
    @include('admin.projects.update')
    @include('admin.projects.delete')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
<style>
    /* Reset list bawaan Mazer yang ke-inherit ke hasil Select2 (padding-left 32px + margin bikin geser) */
    .select2-container--bootstrap-5 .select2-results__options {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    /* Dark mode: paksa Select2 pakai warna Bootstrap/Mazer, tutup putih hardcode bawaan Select2 */
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection,
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection__rendered,
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-dropdown,
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--bs-body-bg);
        border-color: var(--bs-border-color);
        color: var(--bs-body-color);
    }
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
    }
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-results__option--highlighted,
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-results__option--selected {
        background-color: var(--bs-primary);
        color: #fff;
    }
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection__choice,
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection__choice__display {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #fff;
    }
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection__choice__remove {
        color: #fff !important;
        background-color: transparent;
        border-color: rgba(255, 255, 255, 0.5);
        opacity: 1;
        /* kalau × berupa ikon SVG (btn-close), paksa jadi putih */
        filter: brightness(0) invert(1);
    }
    [data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-selection__choice__remove:hover {
        background-color: rgba(255, 255, 255, 0.25);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        // ===== Select2 Init =====
        // dropdownParent wajib diarahkan ke modal supaya select2 tampil di atas modal Bootstrap
        $('#createProjectCategory').select2({ dropdownParent: $('#createModal'), placeholder: 'Pilih Kategori', width: '100%', theme: 'bootstrap-5' });
        $('#createProjectTechStack').select2({ dropdownParent: $('#createModal'), placeholder: 'Pilih Tech Stack', width: '100%', theme: 'bootstrap-5' });
        $('#editProjectCategory').select2({ dropdownParent: $('#editModal'), placeholder: 'Pilih Kategori', width: '100%', theme: 'bootstrap-5' });
        $('#editProjectTechStack').select2({ dropdownParent: $('#editModal'), placeholder: 'Pilih Tech Stack', width: '100%', theme: 'bootstrap-5' });

        function fillSelectOptions(selectEl, items, selectedIds = []) {
            selectEl.empty();
            // single-select butuh option kosong di depan biar placeholder muncul, bukan auto-pilih opsi pertama
            if (!selectEl.prop('multiple')) {
                selectEl.append('<option></option>');
            }
            items.forEach(item => {
                const selected = selectedIds.includes(item.id) ? 'selected' : '';
                selectEl.append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
            });
            selectEl.trigger('change');
        }

        // ===== Load opsi Kategori & Tech Stack (sekali saat halaman dibuka) =====
        let categories = [];
        let techStacks = [];

        Promise.all([
            fetch('{{ route("admin.categories.all") }}').then(r => r.json()),
            fetch('{{ route("admin.tech-stacks.all") }}').then(r => r.json()),
        ]).then(([categoryData, techStackData]) => {
            categories = categoryData;
            techStacks = techStackData;
            fillSelectOptions($('#createProjectCategory'), categories);
            fillSelectOptions($('#createProjectTechStack'), techStacks);
        });

        // ===== DataTable Init =====
        const table = $('#projectsTable').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route("admin.project.list") }}',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'title' },
                { data: 'category', render: c => c ? c.name : '-' },
                {
                    data: 'tech_stacks_project',
                    orderable: false,
                    searchable: false,
                    render: list => (list || []).map(t => t.name).join(', ') || '-'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function () {
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
                emptyTable: 'Tidak ada data project',
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
                const input = form.querySelector('[name="' + field + '"]') || form.querySelector('[name="' + field + '[]"]');
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
        const createForm = document.getElementById('createProjectForm');
        handleAjaxSubmit(createForm, '#createSubmitBtn', '#createFormAlert', 'Simpan Project', 'createModal');

        document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
            const modal = document.getElementById('createModal');
            const alertEl = document.getElementById('createFormAlert');
            clearFormErrors(modal, alertEl);
            createForm.reset();
            $('#createProjectCategory, #createProjectTechStack').val(null).trigger('change');
        });

        // ===== Delete Modal Binding =====
        $('#projectsTable').on('click', '.delete-btn', function () {
            const rowData = table.row($(this).closest('tr')).data();

            document.getElementById('deleteProjectTitle').textContent = rowData.title;
            document.getElementById('deleteProjectForm').action = `/admin/project/${rowData.id}`;
        });

        const deleteForm = document.getElementById('deleteProjectForm');
        deleteForm.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch(deleteForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: new FormData(deleteForm)
            })
            .then(async response => {
                const data = await response.json();
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
                showToast(err.data?.message || 'Gagal menghapus project', 'error');
            });
        });

        // ===== Edit Modal Binding =====
        const editForm = document.getElementById('editProjectForm');
        const editTitleInput = document.getElementById('editProjectTitle');
        const editDescriptionInput = document.getElementById('editProjectDescription');
        const editAlert = document.getElementById('editFormAlert');
        const editSubmitBtn = document.getElementById('editSubmitBtn');

        handleAjaxSubmit(editForm, '#editSubmitBtn', '#editFormAlert', 'Simpan Perubahan', 'editModal');

        $('#projectsTable').on('click', '.edit-btn', function () {
            const id = table.row($(this).closest('tr')).data().id;

            clearFormErrors(editForm, editAlert);
            editForm.reset();
            editSubmitBtn.disabled = true;
            editSubmitBtn.textContent = 'Memuat...';

            fetch(`/admin/project/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                editTitleInput.value = data.title;
                editDescriptionInput.value = data.description;

                const selectedTechStackIds = (data.tech_stacks_project || []).map(t => t.id);
                fillSelectOptions($('#editProjectCategory'), categories, [data.category_id]);
                fillSelectOptions($('#editProjectTechStack'), techStacks, selectedTechStackIds);

                editForm.action = `/admin/project/${id}`;

                editSubmitBtn.disabled = false;
                editSubmitBtn.textContent = 'Simpan Perubahan';
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                editAlert.classList.remove('d-none');
                editAlert.textContent = 'Gagal memuat data project.';
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
