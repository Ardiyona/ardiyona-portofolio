<!-- Create Modal -->
<div class="modal fade text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel">Tambah Project Baru</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="createProjectForm" action="{{ route('admin.project.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="createFormAlert"></div>
                    <label>Kategori: </label>
                    <div class="form-group">
                        <select name="category_id" id="createProjectCategory" class="form-control select2"></select>
                        <span class="text-danger small" id="error-category_id"></span>
                    </div>
                    <label>Tech Stack: </label>
                    <div class="form-group">
                        <select name="tech_stack_id[]" id="createProjectTechStack" class="form-control select2" multiple></select>
                        <span class="text-danger small" id="error-tech_stack_id"></span>
                    </div>
                    <label>Judul: </label>
                    <div class="form-group">
                        <input type="text" name="title" placeholder="Judul Project" class="form-control">
                        <span class="text-danger small" id="error-title"></span>
                    </div>
                    <label>Deskripsi: </label>
                    <div class="form-group">
                        <textarea name="description" placeholder="Deskripsi Project" class="form-control" rows="4"></textarea>
                        <span class="text-danger small" id="error-description"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1" id="createSubmitBtn">Simpan Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
