@extends('layout.main')
@section('judul','Tambah Data Product')

@section('content')
    <form method="post" action="{{url('product/insert')}}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Barcode</label>
                            <input type="text"
                                   class="form-control @error('barcode') is-invalid @enderror"
                                   value="{{old('barcode')}}"
                                   name="barcode">
                            @error('barcode')
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
                            <label for="">Price</label>
                            <input type="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{old('price')}}"
                                   name="price">
                            @error('price')
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
