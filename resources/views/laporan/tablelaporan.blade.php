<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Field </th>
            <th>Data </th>
        </tr>
    </thead>
    <tbody>
    <tr>
            <th>Data Per Tanggal</th>
            <th>{{$transaksi->jenjangWaktu}}</th>
        </tr>
        <tr>
            <th>Jumlah Kendaraan</th>
            <td>{{$transaksi->jumlahKendaraan}} Mobil</td>
        </tr>
        <tr>
            <th>Total Transaksi</th>
            <td>{{$transaksi->totalTransaksi}}x Transaksi</td>
        </tr>
        <tr>
            <th>Rata-rata Transaksi/Hari</th>
            <td>{{$transaksi->rataRataTransaksiPerHari}}x </td>
        </tr>
        <tr>
            <th>Rata-rata Nilai Transaksi</th>
            <td>{{$transaksi->rataRataNilaiTransaksi}}</td>
        </tr>
        <tr>
            <th>Rata-rata Pendapatan/Hari</th>
            <td>{{$transaksi->rataRataPendapatanPerHari}}</td>
        </tr>
        <tr>
            <th>Total Pendapatan</th>
            <td>{{$transaksi->totalPendapatan}}</td>
        </tr>
    </tbody>
</table>