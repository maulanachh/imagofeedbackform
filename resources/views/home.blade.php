<!DOCTYPE html>
<html>

<head>
    <title>Halaman Produk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .produk-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .produk {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .produk:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .produk h3 {
            font-size: 18px;
            margin: 0 0 10px;
            color: #34495e;
        }

        .produk p {
            font-size: 14px;
            color: #666;
            min-height: 40px;
        }

        .produk a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background: #3498db;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .produk a:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>
    <h1>List Produk</h1>
    <div class="produk-container">
        @foreach ($produk as $p)
            <div class="produk">
                <h3>{{ $p->nama_produk }}</h3>
                <p>{{ $p->deskripsi_produk }}</p>
                <a href="/produk/{{ $p->id }}">View Produk</a>
            </div>
        @endforeach
    </div>
</body>

</html>
