<!-- Edit Modal -->
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Pengguna</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="editUserForm" class="editUserForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editFormAlert"></div>
                    <label>Nama: </label>
                    <div class="form-group">
                        <input type="text" name="name" value="" id="editUserName" class="form-control">
                        <span class="text-danger small" id="error-edit-name"></span>
                    </div>
                    <label>Email: </label>
                    <div class="form-group">
                        <input type="email" name="email" value="" id="editUserEmail" class="form-control">
                        <span class="text-danger small" id="error-edit-email"></span>
                    </div>
                    <label>Password (Kosongkan jika tidak ingin mengubah): </label>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password (Min. 8 karakter)" class="form-control">
                        <span class="text-danger small" id="error-edit-password"></span>
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
