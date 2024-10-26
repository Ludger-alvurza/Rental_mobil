<!doctype html>
<html lang="en">
<head>
    <title>Invoice {{$row->code}}</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14pt;
    }

    .header {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    table.data {
        border: 1px solid;
        width: 100%;
        border-collapse: collapse;
    }

    table.data > tbody > tr > td {
        border: 1px solid;
        padding: 5px;
    }

    table.data > thead > tr > th {
        border: 1px solid;
        background-color: #eaeaea;
        padding: 5px;
    }

    table.data > tbody > tr > th {
        border: 1px solid;
        background-color: #eaeaea;
        padding: 5px;
        text-align: left;
    }

</style>
<body>
<div class="header">
    <h1>Rincian Booking</h1>
    <h2>{{$row->code}}</h2>
</div>
<hr>
<table class="data">
    <tr>
        <th>Nama Mobil</th>
        <th>Harga Perhari</th>
        <th>Lama Sewa</th>
        <th>Total</th>
        <th>Telat 1 jam</th>
        <th>Telat 3 jam</th>
        <th>Telat 5 jam</th>
        <th>Telat 24 jam</th>
    </tr>
    @foreach($row->ItemTransaction as $item)
        <tr>
            <td>{{$item->Mobil->name}}</td>
            <td class="right">{{number_format($item->price)}}</td>
            <td class="right">{{$item->qty}}</td>
            <td class="right">{{number_format($row->total)}}</td>
            <td class="right">{{number_format($item->denda)}}</td>
            <td class="right">{{number_format($item->denda1)}}</td>
            <td class="right">{{number_format($item->denda2)}}</td>
            <td class="right">{{number_format($item->denda3)}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>

