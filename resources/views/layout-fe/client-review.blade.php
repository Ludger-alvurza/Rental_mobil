<style>
    .star {
        font-size: 24px; /* Ukuran bintang */
        color: gray; /* Warna bintang kosong */
    }
    .star.filled {
        color: gold; /* Warna bintang terisi */
    }
</style>
<div class="client_section layout_padding">
   <div class="container">
       <div id="custom_slider" class="carousel slide" data-ride="carousel">
           <div class="carousel-inner">
               @foreach (array_chunk($messageRatings->all(), 2) as $index => $chunk)
                   <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                       <div class="client_section_2">
                           <div class="row">
                               @foreach ($chunk as $row)
                                   <div class="col-md-6">
                                       <div class="client_taital_box">
                                           <div class="client_img">
                                               <img src="/assets-fe/images/icons8-user-100.png"> <!-- Ganti dengan path gambar yang sesuai -->
                                           </div>
                                           <h3 class="moark_text">{{ $row->user ? $row->user->name : 'Unknown User' }}</h3>
                                           <p class="client_text">{{ $row->message }}</p>
                                           <p class="client_text">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $row->rating)
                                                    <span class="star filled">&#9733;</span> <!-- Bintang terisi -->
                                                @else
                                                    <span class="star">&#9734;</span> <!-- Bintang kosong -->
                                                @endif
                                            @endfor
                                        </p>
                                       </div>
                                       <div class="quick_icon"><img src="/assets-fe/images/quick-icon.png"></div>
                                   </div>
                               @endforeach
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>
           <a class="carousel-control-prev" href="#custom_slider" role="button" data-slide="prev">
               <i class="fa fa-angle-left"></i>
           </a>
           <a class="carousel-control-next" href="#custom_slider" role="button" data-slide="next">
               <i class="fa fa-angle-right"></i>
           </a>
       </div>
   </div>
</div>
<!-- client section end -->

<!-- contact section start -->
{{-- <div class="contact_section layout_padding">
    <div class="container">
       <div class="row">
          <div class="col-sm-12">
             <h1 class="contact_taital">Get In Touch</h1>
          </div>
       </div>
    </div>
    <div class="container">
       <div class="contact_section_2">
          <div class="row">
             <div class="col-md-12">
                <div class="mail_section_1">
                   <form method="post" action="{{url('message_ratings/insert')}}" enctype="multipart/form-data">
                      @csrf
                      <textarea class="massage-bt @error('message') is-invalid @enderror" placeholder="Message" rows="5" id="comment" name="message">{{ old('message') }}</textarea>
                      @error('message')
                      <div class="invalid-feedback">
                         {{$message}}
                      </div>
                      @enderror
                      <div class="send_bt">
                         <button type="submit" class="btn btn-danger">Send</button>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div> --}}
 