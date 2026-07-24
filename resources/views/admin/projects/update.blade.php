<!-- Edit Modal -->
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Project</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="editProjectForm" class="editProjectForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editFormAlert"></div>
                    <label>Kategori: </label>
                    <div class="form-group">
                        <select name="category_id" id="editProjectCategory" class="form-control select2"></select>
                        <span class="text-danger small" id="error-edit-category_id"></span>
                    </div>
                    <label>Tech Stack: </label>
                    <div class="form-group">
                        <select name="tech_stack_id[]" id="editProjectTechStack" class="form-control select2" multiple></select>
                        <span class="text-danger small" id="error-edit-tech_stack_id"></span>
                    </div>
                    <label>Judul: </label>
                    <div class="form-group">
                        <input type="text" name="title" value="" id="editProjectTitle" class="form-control">
                        <span class="text-danger small" id="error-edit-title"></span>
                    </div>
                    <label>Deskripsi: </label>
                    <div class="form-group">
                        <textarea name="description" id="editProjectDescription" class="form-control" rows="4"></textarea>
                        <span class="text-danger small" id="error-edit-description"></span>
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
