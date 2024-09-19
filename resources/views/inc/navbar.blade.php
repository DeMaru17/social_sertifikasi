<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-xxl">
        <a class="navbar-brand text-white" href="{{ route('posts.index') }}">Social Media</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <form class="d-flex" role="search" method="POST" action="{{ route('search.hashtag') }}">
                        @csrf
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="cari">
                        <button class="btn btn-success" type="submit">Search</button>
                    </form>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white mx-4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('posts.create') }}">+ Post something</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="confirmLogout(event)">
                                Log out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Anda akan keluar dari akun anda',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Kembali'
        }).then((result) => {
            if (result.value) {
                document.location.href = "{{ route('logout') }}";
            }
        });
    }
</script>
