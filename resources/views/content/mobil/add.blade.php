@extends('layout.main')
@section('judul','Tambah Data Mobil')

@section('content')
    <form method="post" action="{{url('mobil/insert')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="mb-3">
                            <label for="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                            accept="image/*" onchange="tampilkanPreview(this, 'tampilFoto')">
                            @error('gambar')
                            <span style="color:red; font-wight: 600; font-size: 9pt">{{$message}}</span>
                            @enderror
                            <p></p>
                            <img id="tampilFoto" onerror="this.onerror=null; this.src='https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABLN930GwaMQz.jpg'; " src="" alt="" width="15%">
                        </div>
                        <div class="form-group">
                            <label for="">Nomor Plat</label>
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
                            <label for="type">Type Mobil</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">Pilih Tipe Mobil</option>
                                <option value="sport" {{ old('type') == 'sport' ? 'selected' : '' }}>Sport</option>
                                <option value="box" {{ old('type') == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="keluarga" {{ old('type') == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>                        
                        <div class="form-group">
                            <label for="">Tahun</label>
                            <input type="text"
                                   class="form-control @error('year') is-invalid @enderror"
                                   value="{{old('year')}}"
                                   name="year">
                            @error('year')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand Mobil</label>
                            <select name="brand" class="form-control @error('brand') is-invalid @enderror">
                                <option value="">Pilih Brand Mobil</option>
                                <option value="toyota" {{ old('brand') == 'toyota' ? 'selected' : '' }}>Toyota</option>
                                <option value="honda" {{ old('brand') == 'honda' ? 'selected' : '' }}>Honda</option>
                                <option value="ford" {{ old('brand') == 'ford' ? 'selected' : '' }}>Ford</option>
                                <option value="chevrolet" {{ old('brand') == 'chevrolet' ? 'selected' : '' }}>Chevrolet</option>
                                <option value="nissan" {{ old('brand') == 'nissan' ? 'selected' : '' }}>Nissan</option>
                                <option value="volkswagen" {{ old('brand') == 'volkswagen' ? 'selected' : '' }}>Volkswagen</option>
                                <option value="hyundai" {{ old('brand') == 'hyundai' ? 'selected' : '' }}>Hyundai</option>
                                <option value="kia" {{ old('brand') == 'kia' ? 'selected' : '' }}>Kia</option>
                                <option value="subaru" {{ old('brand') == 'subaru' ? 'selected' : '' }}>Subaru</option>
                                <option value="mazda" {{ old('brand') == 'mazda' ? 'selected' : '' }}>Mazda</option>
                                <option value="bmw" {{ old('brand') == 'bmw' ? 'selected' : '' }}>BMW</option>
                                <option value="mercedes" {{ old('brand') == 'mercedes' ? 'selected' : '' }}>Mercedes-Benz</option>
                                <option value="audi" {{ old('brand') == 'audi' ? 'selected' : '' }}>Audi</option>
                                <option value="lexus" {{ old('brand') == 'lexus' ? 'selected' : '' }}>Lexus</option>
                                <option value="porsche" {{ old('brand') == 'porsche' ? 'selected' : '' }}>Porsche</option>
                                <option value="jaguar" {{ old('brand') == 'jaguar' ? 'selected' : '' }}>Jaguar</option>
                                <option value="land_rover" {{ old('brand') == 'land_rover' ? 'selected' : '' }}>Land Rover</option>
                                <option value="tesla" {{ old('brand') == 'tesla' ? 'selected' : '' }}>Tesla</option>
                                <option value="volvo" {{ old('brand') == 'volvo' ? 'selected' : '' }}>Volvo</option>
                                <option value="mitsubishi" {{ old('brand') == 'mitsubishi' ? 'selected' : '' }}>Mitsubishi</option>
                            </select>
                            @error('brand')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>                        
                        <div class="form-group">
                            <label for="">Harga Sewa Perhari</label>
                            <input type="price_per_day"
                                   class="form-control @error('price_per_day') is-invalid @enderror"
                                   value="{{old('price_per_day')}}"
                                   name="price_per_day">
                            @error('price_per_day')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Denda Perhari</label>
                            <input type="denda"
                                   class="form-control @error('denda') is-invalid @enderror"
                                   value="{{old('denda')}}"
                                   name="denda">
                            @error('denda')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="availability">Ketersediaan</label>
                            <select id="availability" name="availability" class="form-control @error('availability') is-invalid @enderror">
                                <option value="Tersedia" {{ old('availability') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Sold Out" {{ old('availability') == 'Sold Out' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                            @error('availability')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')

@endpush
