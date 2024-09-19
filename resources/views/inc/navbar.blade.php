<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
      <a style="color: white" class="navbar-brand" href="{{route('posts.index')}}">Social Media</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a style="color: white" class="nav-link" href="{{ route('user.profile') }}">Profile</a>
            </li>
          <li class="nav-item">
            <a style="color: white" class="nav-link" href="{{route('posts.create')}}">+ Post something</a>
          </li>
          <li class="nav-item">
            <form class="d-flex" role="search" method="POST" action="{{ route('search.hashtag') }}">
                @csrf
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="cari">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </li>


          <li class="nav-item mx-4">
            <a href="{{ route('logout') }}" class="sidebar-link btn btn-danger" onclick="confirmLogout(event)">
                <span>Log out</span>
            </a>
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
