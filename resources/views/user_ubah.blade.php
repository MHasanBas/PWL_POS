<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Ubah Data User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Form Ubah Data User</h1>
        <a href="/user" class="btn btn-secondary mb-3">Kembali</a>
        
        <form method="POST" action="{{ url('/user/ubah_simpan/' . $data->user_id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukan Username" value="{{ $data->username }}" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama" value="{{ $data->nama }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password (biarkan kosong jika tidak diubah)">
            </div>

            <div class="mb-3">
                <label for="level_id" class="form-label">Level ID</label>
                <input type="number" name="level_id" id="level_id" class="form-control" placeholder="Masukan ID Level" value="{{ $data->level_id }}" required>
            </div>

            <button type="submit" class="btn btn-success">Ubah</button>
        </form>
    </div>
</body>
</html>
