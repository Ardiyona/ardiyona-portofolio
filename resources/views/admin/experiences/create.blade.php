<!-- Create Modal -->
<div class="modal fade text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel">Tambah Pengalaman Baru</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="createExperienceForm" action="{{ route('admin.experience.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="createFormAlert"></div>
                    <label>Posisi: </label>
                    <div class="form-group">
                        <input type="text" name="position" placeholder="Posisi" class="form-control">
                        <span class="text-danger small" id="error-position"></span>
                    </div>
                    <label>Perusahaan: </label>
                    <div class="form-group">
                        <input type="text" name="company" placeholder="Perusahaan" class="form-control">
                        <span class="text-danger small" id="error-company"></span>
                    </div>
                    <label>Lokasi: </label>
                    <div class="form-group">
                        <input type="text" name="location" placeholder="Lokasi" class="form-control">
                        <span class="text-danger small" id="error-location"></span>
                    </div>
                    <label>Jenis Pekerjaan: </label>
                    <div class="form-group">
                        <select name="work_arrangement" class="form-control">
                            <option value="">Pilih Jenis Pekerjaan</option>
                            <option value="fulltime">Full Time</option>
                            <option value="parttime">Part Time</option>
                            <option value="internship">Magang</option>
                            <option value="freelance">Freelance</option>
                        </select>
                        <span class="text-danger small" id="error-work_arrangement"></span>
                    </div>
                    <label>Gaya Kerja: </label>
                    <div class="form-group">
                        <select name="work_style" class="form-control">
                            <option value="">Pilih Gaya Kerja</option>
                            <option value="onsite">On-site</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="remote">Remote</option>
                        </select>
                        <span class="text-danger small" id="error-work_style"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            {{-- hidden dikirim duluan supaya unchecked tetap kirim "0"; checkbox setelahnya menimpa jadi "1" saat dicentang --}}
                            <input type="hidden" name="is_currently_working" value="0">
                            <input type="checkbox" name="is_currently_working" value="1" class="form-check-input" id="createIsWorking">
                            <label class="form-check-label" for="createIsWorking">Masih bekerja di sini</label>
                        </div>
                        <span class="text-danger small" id="error-is_currently_working"></span>
                    </div>
                    <label>Tanggal Mulai (MM/YYYY): </label>
                    <div class="form-group">
                        <input type="text" name="work_start" placeholder="07/2026" class="form-control">
                        <span class="text-danger small" id="error-work_start"></span>
                    </div>
                    <label>Tanggal Selesai (MM/YYYY): </label>
                    <div class="form-group">
                        <input type="text" name="work_end" placeholder="07/2026" class="form-control" id="createWorkEnd">
                        <span class="text-danger small" id="error-work_end"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1" id="createSubmitBtn">Simpan Pengalaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
