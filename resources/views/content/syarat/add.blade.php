@extends('layout.main')
@section('judul','Tambah Data Syarat')

@section('content')
    <form method="post" action="{{url('syarat/insert')}}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">keterangan</label>
                            <textarea type="text"
                                   class="form-control @error('keterangan') is-invalid @enderror"
                                   value="{{old('keterangan')}}"
                                   name="keterangan"></textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
