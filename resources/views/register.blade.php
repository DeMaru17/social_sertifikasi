<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <style>
        .card {
            max-width: 300px; /* reduce the width of the card */
            margin: 40px auto; /* center the card horizontally */
            position: absolute; /* tambahkan posisi absolut */
            top: 50%; /* atur posisi vertikal ke 50% */
            left: 50%; /* atur posisi horizontal ke 50% */
            transform: translate(-50%, -50%); /* atur transformasi untuk memindahkan card ke tengah */
        }
    </style>
</head>

<div class="card">
    @include('sweetalert::alert')
    <div class="card-header">
      <h5 align="center" class="card-title">Register</h5>
    </div>
    <div class="card-body">
      <form action="{{route('action-register')}}" method="post">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Enter nama">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
        <a href="{{route('login')}}" class="btn btn-danger w-100">Kembali</a>
      </form>
    </div>
</div>
