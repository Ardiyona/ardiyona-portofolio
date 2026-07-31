@extends('layouts.admin')

@section('title', 'Daftar Pengalaman')
@section('page-title', 'Manajemen Pengalaman')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                Daftar Pengalaman
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Pengalaman
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="experiencesTable">
                    <thead>
                        <tr>
                            <th>Posisi</th>
                            <th>Perusahaan</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Gaya Kerja</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

    @include('admin.experiences.create')
    @include('admin.experiences.update')
    @include('admin.experiences.delete')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ===== Label enum =====
        const ARRANGEMENT_LABELS = { fulltime: 'Full Time', parttime: 'Part Time', internship: 'Magang', freelance: 'Freelance' };
        const STYLE_LABELS = { onsite: 'On-site', hybrid: 'Hybrid', remote: 'Remote' };

        // ===== Konversi tanggal =====
        // DB simpan Y-m-d, form pakai m/Y
        function ymdToMonthYear(value) {
            if (!value) return '';
            const [y, m] = value.split('-');
            return `${m}/${y}`;
        }

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

        // ===== Toggle: masih bekerja -> nonaktifkan tanggal selesai =====
        function bindWorkingToggle(checkbox, workEndInput) {
            function sync() {
                if (checkbox.checked) {
                    workEndInput.value = '';
                    workEndInput.disabled = true;
                } else {
                    workEndInput.disabled = false;
                }
            }
            checkbox.addEventListener('change', sync);
            return sync;
        }

        // ===== DataTable Init =====
        const table = $('#experiencesTable').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route("admin.experience.list") }}',
                dataSrc: 'data'
            },
            columns: [
                { data: 'position' },
                { data: 'company' },
                { data: 'location' },
                { data: 'work_arrangement', render: v => ARRANGEMENT_LABELS[v] || v },
                { data: 'work_style', render: v => STYLE_LABELS[v] || v },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (row) {
                        const start = ymdToMonthYear(row.work_start);
                        const end = Number(row.is_currently_working) ? 'Sekarang' : (ymdToMonthYear(row.work_end) || '-');
                        return `${start} - ${end}`;
                    }
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
                emptyTable: 'Tidak ada data pengalaman',
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
        const createForm = document.getElementById('createExperienceForm');
        const createIsWorking = document.getElementById('createIsWorking');
        const createWorkEnd = document.getElementById('createWorkEnd');
        bindWorkingToggle(createIsWorking, createWorkEnd);
        handleAjaxSubmit(createForm, '#createSubmitBtn', '#createFormAlert', 'Simpan Pengalaman', 'createModal');

        document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
            const modal = document.getElementById('createModal');
            clearFormErrors(modal, document.getElementById('createFormAlert'));
            createForm.reset();
            createWorkEnd.disabled = false;
        });

        // ===== Delete Modal Binding =====
        $('#experiencesTable').on('click', '.delete-btn', function () {
            const rowData = table.row($(this).closest('tr')).data();
            document.getElementById('deleteExperienceTitle').textContent = `${rowData.position} di ${rowData.company}`;
            document.getElementById('deleteExperienceForm').action = `/admin/experience/${rowData.id}`;
        });

        const deleteForm = document.getElementById('deleteExperienceForm');
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
                showToast(err.data?.message || 'Gagal menghapus pengalaman', 'error');
            });
        });

        // ===== Edit Modal Binding =====
        const editForm = document.getElementById('editExperienceForm');
        const editAlert = document.getElementById('editFormAlert');
        const editSubmitBtn = document.getElementById('editSubmitBtn');
        const editIsWorking = document.getElementById('editIsWorking');
        const editWorkEnd = document.getElementById('editWorkEnd');
        const syncEditWorkEnd = bindWorkingToggle(editIsWorking, editWorkEnd);

        handleAjaxSubmit(editForm, '#editSubmitBtn', '#editFormAlert', 'Simpan Perubahan', 'editModal');

        $('#experiencesTable').on('click', '.edit-btn', function () {
            const id = table.row($(this).closest('tr')).data().id;

            clearFormErrors(editForm, editAlert);
            editForm.reset();
            editSubmitBtn.disabled = true;
            editSubmitBtn.textContent = 'Memuat...';

            fetch(`/admin/experience/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('editPosition').value = data.position;
                document.getElementById('editCompany').value = data.company;
                document.getElementById('editLocation').value = data.location;
                document.getElementById('editWorkArrangement').value = data.work_arrangement;
                document.getElementById('editWorkStyle').value = data.work_style;
                document.getElementById('editWorkStart').value = ymdToMonthYear(data.work_start);
                editWorkEnd.value = ymdToMonthYear(data.work_end);
                editIsWorking.checked = Number(data.is_currently_working) === 1;
                syncEditWorkEnd();

                editForm.action = `/admin/experience/${id}`;

                editSubmitBtn.disabled = false;
                editSubmitBtn.textContent = 'Simpan Perubahan';
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                editAlert.classList.remove('d-none');
                editAlert.textContent = 'Gagal memuat data pengalaman.';
                editSubmitBtn.disabled = false;
                editSubmitBtn.textContent = 'Simpan Perubahan';
            });
        });

        document.getElementById('editModal').addEventListener('hidden.bs.modal', function () {
            clearFormErrors(editForm, editAlert);
            editWorkEnd.disabled = false;
        });

    });
</script>
@endpush
