<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Presensi Kelas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h4 class="text-center">{{ $title }}</h4>


    <table class="table table-bordered">
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Hadir</th>
            <th>Izin</th>
            <th>Alpha</th>
            <th>Persentase</th>
            <th>Keterangan</th>
        </tr>
        @foreach($siswa as $val)
        <tr>
            <td>{{ $val->nis_siswa }}</td>
            <td>{{ $val->nama_siswa }}</td>
            <td>{{ $val->total_hadir_presensi }}</td>
            <td>{{ $val->total_izin_presensi }}</td>
            <td>{{ $val->total_alpha_presensi }}</td>
            <td>{{ $val->persentase }}%</td>
            <td>
                @if ($val->persentase < 75) Tidak Dapat Mengikuti Ujian @else Dapat Mengikuti Ujian @endif </td>
        </tr>
        @endforeach
    </table>
    <div class="signature">
        Batam, {{$date}}<br>
        Kepala Sekolah<br><br><br><br>
        Agung Mulia Eko Putra<br>
    </div>
</body>

</html>