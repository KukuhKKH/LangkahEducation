<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
   <table>
      <thead>
         <tr>
            <th>No</th>
            <th>Nama Gelombang</th>
            <th>Nama Siswa</th>
            <th>Bank</th>
            <th>Biaya</th>
            <th>Waktu</th>
         </tr>
      </thead>
      <tbody>
         @forelse ($data as $value)
         <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $value->gelombang->nama }}</td>
            <td>{{ $value->user->name }}</td>
            <td>{{ $value->pembayaran_bukti()->first()->bank->nama }}</td>
            @php
               $harga_gelombang = $value->gelombang->harga;
               $kode = $value->kode_transfer;
            @endphp
            <td>Rp. {{ number_format($harga_gelombang + $kode) }}</td>
            <td>{{ date('d F Y', strtotime($value->created_at)) }}</td>
         </tr>
         @empty
         <tr>
            <td colspan="5">
               <h6>Tidak Ada Pembayaran</h6>
            </td>
         </tr>
         @endforelse
      </tbody>
   </table>
</body>

</html>