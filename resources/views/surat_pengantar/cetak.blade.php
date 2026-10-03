<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar {{ $surat->warga->nama }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 40px; color: #111; }
        .kop { text-align: center; border-bottom: 3px double #111; padding-bottom: 10px; margin-bottom: 30px; }
        .kop h1 { margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; }
        .kop p { margin: 2px 0; font-size: 12px; }
        .judul { text-align: center; text-transform: uppercase; font-weight: bold; text-decoration: underline; margin: 30px 0; }
        .isi { line-height: 1.8; }
        .table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .table td { padding: 4px 8px; vertical-align: top; }
        .signature { margin-top: 60px; float: right; width: 250px; text-align: center; }
        .print-btn { position: fixed; top: 20px; right: 20px; padding: 8px 16px; background: #059669; color: #fff; border: none; border-radius: 8px; cursor: pointer; }
        @media print {
            body { margin: 0.75in; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Cetak (Ctrl+P)</button>

    <div class="kop">
        <h1>Rukun Tetangga 05 / Rukun Warga 02</h1>
        <p>Kota Jakarta • Kecamatan Contoh • Kelurahan Contoh</p>
        <p>Alamat: Jl. Contoh No. 123, RT 05 RW 02</p>
    </div>

    <h2 class="judul">Surat Keterangan Domisili / Pengantar</h2>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini Ketua RT 05 / RW 02, menerangkan bahwa:</p>

        <table class="table">
            <tr><td width="180">Nama</td><td>: {{ $surat->warga->nama }}</td></tr>
            <tr><td>NIK</td><td>: {{ $surat->warga->nik ?? '-' }}</td></tr>
            <tr><td>Tempat / Tgl Lahir</td><td>: {{ $surat->warga->tempat_lahir ?? '-' }}{{ $surat->warga->tempat_lahir && $surat->warga->tanggal_lahir ? ', ' : '' }}{{ $surat->warga->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $surat->warga->jenis_kelamin }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $surat->warga->alamat }}, No. {{ $surat->warga->nomor_rumah }}</td></tr>
        </table>

        <p>Benar adalah warga di lingkungan RT 05 / RW 02. Surat ini dibuat sebagai pengantar untuk keperluan <strong>{{ $surat->keterangan ?? 'administrasi' }}</strong>.</p>

        <p>Demikian surat pengantar ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Ketua RT 05 / RW 02</p>
        <br><br><br>
        <p><strong>( ____________________ )</strong></p>
    </div>
</body>
</html>
