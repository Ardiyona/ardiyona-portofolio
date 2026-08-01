<header class="mb-3 d-flex justify-content-between align-items-center">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>

    <div class="dropdown ms-auto">
        <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-3"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 12rem;">
            <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="bi bi-person me-2"></i> Profile
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" id="logout-form-header" style="display: none;">
                    @csrf
                </form>
                <a class="dropdown-item text-danger" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</header>

<!-- Profile Modal -->
<div class="modal fade text-left" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="profileModalLabel">Edit Profile</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <label>Nama: </label>
                    <div class="form-group">
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <label>Password (Kosongkan jika tidak ingin mengubah): </label>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password (Min. 8 karakter)" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ms-1">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any() || session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('profileModal')).show();
    });
</script>
@endif
