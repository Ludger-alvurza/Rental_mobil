<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Tanggal Lahir</th>
        <th>nomer telepon</th>
        <th>Jenis Kelamin</th>
        <th>Umur</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i =1;
    @endphp
    @foreach($rows as $user)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->dob}}</td>
            <td>{{$user->no_telepon}}</td>
            <td>{{$user->jk}}</td>
            <td>{{$user->age}} Tahun</td>
        </tr>
    @endforeach
    </tbody>
</table>

