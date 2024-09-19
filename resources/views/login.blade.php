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
    <div class="card-header">
      <h5 align="center" class="card-title">Login</h5>
    </div>
    <div class="card-body">
      <form action="{{route('action-login')}}" method="post">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
</div>
