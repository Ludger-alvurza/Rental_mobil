{{-- <style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .footer_section {
        background-color: #333;
        color: #fff;
        padding: 20px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 1000;
        /* Menjaga footer tetap di bawah */
    }

    .footer_section .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer_section_2 .row {
        margin-top: 20px;
    }

    .footer_section .container .row {
        padding-left: 15px;
        padding-right: 15px;
    }

    .footer_section .col {
        text-align: center;
    }

    .footer_section .col h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .footer_section .col p {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .social_icon ul {
        list-style: none;
        padding: 0;
    }

    .social_icon ul li {
        display: inline;
        margin-right: 10px;
    }

    .social_icon ul li a {
        color: #fff;
        font-size: 20px;
    }

    .social_icon ul li a:hover {
        color: #0d6efd;
    }

    .main-content {
        flex-grow: 1;
        padding-bottom: 80px;
        /* Memberikan ruang untuk footer agar tidak tertutup */
    }
</style> --}}
<div class="footer_section layout_padding" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footeer_logo"><img src="/assets-fe/images/logo.png"></div>
            </div>
        </div>
        <div class="footer_section_2">
            <div class="row">
                <div class="col">
                    <h4 class="footer_taital">Bergabunglah dengan Kami!</h4>
                    <p class="footer_text">Dapatkan pembaruan terbaru dan penawaran menarik dari RentalCar. Masukkan
                        email kamu dan jangan lewatkan informasi penting seputar rental mobil.</p>
                    <div class="form-group">
                        <div class="subscribe_bt"><a href="{{ url('/login') }}">Subscribe</a></div>
                    </div>
                </div>
                <div class="col">
                    <h4 class="footer_taital">Tentang Kami</h4>
                    <p class="lorem_text">RentalCar adalah solusi terbaik untuk semua kebutuhan rental mobil kamu. Kami
                        menawarkan kendaraan berkualitas dan layanan pelanggan yang ramah.</p>
                </div>
                <div class="col">
                    <h4 class="footer_taital">Tautan Berguna</h4>
                    <p class="lorem_text">Temukan informasi lebih lanjut tentang layanan kami, syarat dan ketentuan,
                        serta cara menghubungi tim support kami.</p>
                </div>
                <div class="col">
                    <h4 class="footer_taital">Kesempatan Investasi</h4>
                    <p class="lorem_text">Bergabunglah dengan kami dalam membangun masa depan yang lebih baik di
                        industri rental mobil. Temukan peluang investasi menarik di RentalCar.</p>
                </div>
                <div class="col">
                    <h4 class="footer_taital">Hubungi Kami</h4>
                    <div class="location_text"><a href="#"><i class="fa fa-map-marker"
                                aria-hidden="true"></i><span class="padding_left_15">Location</span></a></div>
                    <div class="location_text"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i><span
                                class="padding_left_15">(+71) 8522369417</span></a></div>
                    <div class="location_text"><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span
                                class="padding_left_15">demo@gmail.com</span></a></div>
                    <div class="social_icon">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free
                            Html Templates</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
