<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f9;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        select {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .feedback {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .feedback:last-child {
            border-bottom: none;
        }

        .feedback strong {
            color: #007bff;
        }

        .no-feedback {
            color: #777;
            font-style: italic;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Selamat Datang, {{ auth()->user()->username }}</h2>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit"
                    style="background:#dc3545; color:white; border:none; padding:8px 16px; border-radius:6px; cursor:pointer; font-size:14px;">
                    Logout
                </button>
            </form>
        </div>

        <form method="GET" action="{{ route('dashboard') }}">
            <label for="produk">Pilih Produk:</label>
            <select name="produk_id" id="produk" onchange="this.form.submit()">
                <option value="">-- Pilih Produk --</option>
                @foreach ($produk as $p)
                    <option value="{{ $p->id }}" {{ request('produk_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_produk }}
                    </option>
                @endforeach
            </select>
        </form>

        <h3>Feedback Produk</h3>
        @if ($feedback->isEmpty())
            <div class="no-feedback">Belum ada feedback untuk produk ini.</div>
        @else
            @foreach ($feedback as $fb)
                <div class="feedback">
                    <strong>{{ $fb->nama_user }}</strong> ({{ $fb->email_user }})<br>
                    <span>{{ $fb->komentar_user }}</span>
                </div>
            @endforeach
        @endif
    </div>
</body>

</html>
