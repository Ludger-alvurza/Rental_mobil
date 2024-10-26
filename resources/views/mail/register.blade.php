<h3>Halo {{$user->name}}</h3>
Pendaftaran sudah diterima, silahkan klik link berikut untuk aktivasi akun anda
<p>
    <a href="{{url("/register/activation/$user->token_activation")}}">Klik disini</a>
</p>

