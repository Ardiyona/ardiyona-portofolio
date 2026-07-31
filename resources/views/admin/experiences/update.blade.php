<!-- Edit Modal -->
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Pengalaman</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="editExperienceForm" class="editExperienceForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editFormAlert"></div>
                    <label>Posisi: </label>
                    <div class="form-group">
                        <input type="text" name="position" id="editPosition" class="form-control">
                        <span class="text-danger small" id="error-edit-position"></span>
                    </div>
                    <label>Perusahaan: </label>
                    <div class="form-group">
                        <input type="text" name="company" id="editCompany" class="form-control">
                        <span class="text-danger small" id="error-edit-company"></span>
                    </div>
                    <label>Lokasi: </label>
                    <div class="form-group">
                        <input type="text" name="location" id="editLocation" class="form-control">
                        <span class="text-danger small" id="error-edit-location"></span>
                    </div>
                    <label>Jenis Pekerjaan: </label>
                    <div class="form-group">
                        <select name="work_arrangement" id="editWorkArrangement" class="form-control">
                            <option value="">Pilih Jenis Pekerjaan</option>
                            <option value="fulltime">Full Time</option>
                            <option value="parttime">Part Time</option>
                            <option value="internship">Magang</option>
                            <option value="freelance">Freelance</option>
                        </select>
                        <span class="text-danger small" id="error-edit-work_arrangement"></span>
                    </div>
                    <label>Gaya Kerja: </label>
                    <div class="form-group">
                        <select name="work_style" id="editWorkStyle" class="form-control">
                            <option value="">Pilih Gaya Kerja</option>
                            <option value="onsite">On-site</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="remote">Remote</option>
                        </select>
                        <span class="text-danger small" id="error-edit-work_style"></span>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="hidden" name="is_currently_working" value="0">
                            <input type="checkbox" name="is_currently_working" value="1" class="form-check-input" id="editIsWorking">
                            <label class="form-check-label" for="editIsWorking">Masih bekerja di sini</label>
                        </div>
                        <span class="text-danger small" id="error-edit-is_currently_working"></span>
                    </div>
                    <label>Tanggal Mulai (MM/YYYY): </label>
                    <div class="form-group">
                        <input type="text" name="work_start" id="editWorkStart" placeholder="07/2026" class="form-control">
                        <span class="text-danger small" id="error-edit-work_start"></span>
                    </div>
                    <label>Tanggal Selesai (MM/YYYY): </label>
                    <div class="form-group">
                        <input type="text" name="work_end" id="editWorkEnd" placeholder="07/2026" class="form-control">
                        <span class="text-danger small" id="error-edit-work_end"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1" id="editSubmitBtn">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
