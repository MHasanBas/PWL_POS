@extends('layouts.template')
@section('content')
    <style>
        .profile-image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-user-img {
            width: 100px;
            /* Adjust as needed */
            height: 100px;
            /* Adjust as needed */
            object-fit: cover;
        }

        .ubah-foto-btn {
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="profile-image-container">
                            <img class="profile-user-img img-fluid img-circle" src="{{ route('profil.avatar') }}" alt="User profile picture">
                            <form action="{{ route('upload.foto') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="upload_foto" name="foto" accept="image/*">
                                <button type="submit" class="btn btn-primary btn-sm mt-2 ubah-foto-btn">Ubah Foto</button>
                                <br>
                            </form>
                        </div>

                        <h3 class="profile-username text-center">{{ auth()->user()->nama }}</h3>
                        <p class="text-muted text-center"> {{ auth()->user()->level->level_nama }} </p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right"
                                    style="pointer-events: none; color:black">{{ auth()->user()->username }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Nama</b> <a class="float-right"
                                    style="pointer-events: none; color:black">{{ auth()->user()->nama }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Tingkat Level</b> <a class="float-right"
                                    style="pointer-events: none; color:black">{{ auth()->user()->level->level_nama }}</a>
                            </li>
                        </ul>

                        <a href="{{ url('/') }}" class="btn btn-primary btn-block"><b>Kembali</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection