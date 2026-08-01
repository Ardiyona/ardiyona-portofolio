<!-- Create Modal -->
<div class="modal fade text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel">Tambah Tech Stack Baru</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="createTechStackForm" action="{{ route('admin.tech-stacks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="createFormAlert"></div>
                    <label>Kode: </label>
                    <div class="form-group">
                        <input type="text" name="code" placeholder="Kode" class="form-control">
                        <span class="text-danger small" id="error-code"></span>
                    </div>
                    <label>Nama: </label>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Tech Stack" class="form-control">
                        <span class="text-danger small" id="error-name"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1" id="createSubmitBtn">Simpan Tech Stack</button>
                </div>
            </form>
        </div>
    </div>
</div>
