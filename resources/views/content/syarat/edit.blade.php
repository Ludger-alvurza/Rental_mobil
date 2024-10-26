@extends('layout.main')
@section('judul','Edit Data Syarat')

@section('content')
    <form method="post" action="{{url('syarat/update')}}">
        @csrf
        <input type="hidden" name="id" value="{{$syarat->id}}"/>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea type="text"
                                   class="form-control @error('keterangan') is-invalid @enderror"
                                   value="{{$syarat->keterangan}}"
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

