@extends('layout.main')
@section('judul','Tambah Data mobil')

@section('content')
    <form method="post" action="{{url('pesanan/insert')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">no_plat</label>
                            <input type="text"
                                   class="form-control @error('no_plat') is-invalid @enderror"
                                   value="{{old('no_plat')}}"
                                   name="no_plat">
                            @error('no_plat')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{old('name')}}"
                                   name="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Nama Mobil</label>
                            <input type="text"
                                   class="form-control @error('name_motor') is-invalid @enderror"
                                   value="{{old('name_motor')}}"
                                   name="name_motor">
                            @error('name_motor')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Lama Sewa</label>
                            <input type="text"
                                   class="form-control @error('lama_sewa') is-invalid @enderror"
                                   value="{{old('lama_sewa')}}"
                                   name="lama_sewa">
                            @error('lama_sewa')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text"
                                   class="form-control @error('keterangan') is-invalid @enderror"
                                   value="{{old('keterangan')}}"
                                   name="keterangan">
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="hidden"
                                   class="form-control @error('user_id') is-invalid @enderror"
                                   value="{{$userT->id}}"
                                   name="user_id">
                            @error('user_id')
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
