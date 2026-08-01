<!-- Edit Modal -->
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Kategori</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="editCategoryForm" class="editCategoryForm"
                action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editFormAlert"></div>
                    <label>Kode: </label>
                    <div class="form-group">
                        <input type="text" name="code" value="" id="editCategoryCode"
                            class="form-control" required>
                        <span class="text-danger small" id="error-edit-code"></span>
                    </div>
                    <label>Nama: </label>
                    <div class="form-group">
                        <input type="text" name="name" value="" id="editCategoryName"
                            class="form-control" required>
                        <span class="text-danger small" id="error-edit-name"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1" id="editSubmitBtn">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
