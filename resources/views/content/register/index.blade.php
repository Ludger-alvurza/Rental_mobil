@extends('layout.login')
@section('judul','Register User Baru')

@section('content')
    <p class="login-box-msg">Registrasi User Baru</p>
    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
            @error('name') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">Alamat</label>
            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror">
            @error('alamat') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">No Telepon</label>
            <input type="tel" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror">
            @error('no_telepon') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <div class="form-group">
            <label for="">Tanggal Lahir</label>
            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror">
            @error('dob') 
            <div class="invalid-feedback">
            {{$message}}
            </div>
             @enderror
        </div>
        <button class="btn btn-primary btn-block" type="submit">Register</button>
        <a href="/login" class="btn btn-info btn-block">Kembali</a>
    </form>
@endsection
