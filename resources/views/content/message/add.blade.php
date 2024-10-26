@extends('layout.main')
@section('judul','Tambah Data Message Rating')

@section('content')
    <form method="post" action="{{url('message_ratings/insert')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $mobil->id }}" />
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message"
                                      class="form-control @error('message') is-invalid @enderror"
                                      required maxlength="30">{{old('message')}}</textarea>
                            @error('message')
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
