<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pegawai</th>
            <th>Departemen</th>
            <th>Tanggal Penilaian</th>
            <th>Waktu Penilaian</th>
            <th>Detail Penilaian</th>
            <th>Total Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penilaians as $penilaian)
            <tr>
                <td>{{ $penilaian->id }}</td>
                <td>{{ $penilaian->pegawai->nama ?? 'Tidak diketahui' }}</td>
                <td>{{ $penilaian->pegawai->departemen ?? 'Tidak diketahui' }}</td>
                <td>{{ $penilaian->tanggal_penilaian }}</td>
                <td>{{ $penilaian->waktu_penilaian }}</td>
                <td>
                    {{ $penilaian->detailPenilaian->map(function($detail) {
                        return $detail->nilai ? 'Ya' : 'Tidak';
                    })->implode(', ') }}
                </td>
                <td>{{ $penilaian->total_nilai }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
