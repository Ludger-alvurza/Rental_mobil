@extends('layout.main')
@section('judul',"Halaman Murid")

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Lahir</th>
                            <th>Nama Dosen Wali</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $s)
                            <tr>
                                <td>{{$s->name}}</td>
                                <td>{{$s->email}}</td>
                                <td>{{$s->dob}}</td>
                                <td>{{$s->teacher->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$students->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
