<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0 0 2px 0;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 0;
            font-size: 13px;
            color: #555;
        }

        hr {
            border: none;
            border-top: 2px solid #3b82f6;
            margin: 12px 0 18px 0;
        }

        .info {
            margin-bottom: 10px;
            padding: 10px 18px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            width: 100%;
            box-sizing: border-box;
        }

        .info p {
            margin: 2px 0;
            font-size: 12px;
        }

        .table-container {
            margin: 0 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 7px 6px;
            font-size: 12px;
        }

        th {
            background: #e0e7ef;
            color: #222;
            font-weight: 600;
        }

        td {
            background: #fff;
        }

        .total {
            text-align: right;
            margin-top: 12px;
            font-size: 15px;
            font-weight: bold;
            color: #1d4ed8;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #555;
        }

        .highlight {
            color: #1d4ed8;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Avachive Laundry</h2>
    </div>
    <hr>

    <div class="info">
        <table style="width:100%; border:none;">
            <tr>
                <td style="border:none;"><b>Nota Order :</b></td>
                <td style="border:none;" class="highlight">{{ $order->id }}</td>
                <td style="border:none;"><b>Tanggal:</b></td>
                <td style="border:none;">{{ $order->updated_at->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="border:none;"><b>Pelanggan:</b></td>
                <td style="border:none;">{{ $order->pelanggan->nama ?? '-' }}</td>
                <td style="border:none;"><b>No HP:</b></td>
                <td style="border:none;">{{ $order->pelanggan->no_handphone ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border:none;"><b>Alamat:</b></td>
                <td style="border:none;" colspan="3">{{ $order->pelanggan->detail_alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border:none;"><b>Status:</b></td>
                <td style="border:none;" colspan="3">{{ $order->status }}</td>
            </tr>
        </table>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($layanan as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="text-align:left;">{{ $item['nama'] }}</td>
                        <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['kuantitas'] }}</td>
                        <td>Rp {{ number_format($item['harga'] * $item['kuantitas'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada item layanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="total">
        Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Terima kasih telah mempercayakan cucian Anda kepada kami 🙏</p>
        <p><b>Avachive Laundry</b></p>
    </div>
</body>

</html>