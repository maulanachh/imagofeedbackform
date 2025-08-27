<!DOCTYPE html>
<html>

<head>
    <title>{{ $produk->nama_produk }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 24px;
        }

        h1,
        h2 {
            color: #2c3e50;
            margin-top: 0;
        }

        /* Product Card */
        .product-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
        }

        .product-card p {
            color: #555;
            margin-bottom: 0;
        }

        /* form dan text area */
        form {
            background: #fff;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
            width: 100%;
            overflow: hidden;
        }

        form input,
        form textarea {
            display: block;
            width: 100%;
            max-width: 100%;
            padding: 12px 14px;
            margin: 8px 0 12px;
            border: 1px solid #d0d5db;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            resize: vertical;
            line-height: 1.4;
        }

        form input:focus,
        form textarea:focus {
            border-color: #4aa3f0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 163, 240, 0.12);
        }

        /* tombol */
        button {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        button[disabled] {
            opacity: 0.7;
            cursor: default;
        }

        /* pesan sukses & error */
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px 14px;
            border-radius: 8px;
            margin-top: 8px;
            display: none;
        }

        .error {
            color: #d0342c;
            font-size: 13px;
            margin-top: -6px;
            margin-bottom: 8px;
        }

        /* list feedback */
        .feedback-list {
            background: #fff;
            padding: 14px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .feedback-item {
            border-bottom: 1px solid #f0f0f0;
            padding: 12px 0;
        }

        .feedback-item:last-child {
            border-bottom: none;
        }

        .feedback-item strong {
            color: #2c3e50;
        }

        .feedback-item small {
            color: #888;
            font-size: 12px;
        }

        /* fungsi responsive */
        @media (max-width: 600px) {
            .container {
                padding: 14px;
            }

            form {
                padding: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Produk Card -->
        <div class="product-card">
            <h1>{{ $produk->nama_produk }}</h1>
            <p>{{ $produk->deskripsi_produk }}</p>
        </div>

        <!-- form feedback -->
        <h2>💬 Berikan Feedback</h2>
        <form id="feedback_form" autocomplete="off">
            <input type="text" id="nama_user" name="nama_user" placeholder="Nama Anda">
            <div id="error_name" class="error"></div>

            <input type="email" id="email_user" name="email_user" placeholder="Email Anda">
            <div id="error_email" class="error"></div>

            <textarea id="komentar_user" name="komentar_user" placeholder="Tulis feedback Anda..." rows="5"></textarea>
            <div id="error_comment" class="error"></div>

            <button type="submit" id="submit_btn">Kirim Feedback</button>
            <div id="success_message" class="success">✅ Feedback berhasil disimpan</div>
        </form>

        <!-- list feedback -->
        <h2>📢 Customer Feedback</h2>
        <div id="feedback_list" class="feedback-list"></div>
    </div>

    <script>
        const produk_id = {{ $produk->id }};
        const form = document.getElementById('feedback_form');
        const list = document.getElementById('feedback_list');
        const submit_btn = document.getElementById('submit_btn');
        const success_message = document.getElementById('success_message');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // load feedback per produk
        async function loadFeedback() {
            try {
                const res = await fetch(`/api/produk/${produk_id}/feedback`);
                const data = await res.json();
                list.innerHTML = data.length ? data.map(item => `
                    <div class="feedback-item">
                        <strong>${item.nama_user}</strong>
                        <small>(${item.email_user})</small><br>
                        ${item.komentar_user}
                    </div>
                `).join('') : `<p>Belum ada feedback untuk produk ini.</p>`;
            } catch (err) {
                list.innerHTML = `<p>Gagal memuat feedback.</p>`;
            }
        }

        // validasi form
        function validateForm() {
            let valid = true;
            document.getElementById('error_name').innerText = '';
            document.getElementById('error_email').innerText = '';
            document.getElementById('error_comment').innerText = '';

            const name = document.getElementById('nama_user').value.trim();
            const email = document.getElementById('email_user').value.trim();
            const comment = document.getElementById('komentar_user').value.trim();

            if (!name) {
                document.getElementById('error_name').innerText = 'Nama wajib diisi';
                valid = false;
            }
            if (!email) {
                document.getElementById('error_email').innerText = 'Email wajib diisi';
                valid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('error_email').innerText = 'Email tidak valid';
                valid = false;
            }
            if (!comment) {
                document.getElementById('error_comment').innerText = 'feedback wajib diisi';
                valid = false;
            }

            return valid;
        }

        // submit form
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!validateForm()) return;

            const form_data = new FormData(form);

            submit_btn.disabled = true;
            submit_btn.innerText = "Mengirim...";

            try {
                const res = await fetch(`/api/produk/${produk_id}/feedback-post`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: form_data
                });

                if (res.ok) {
                    form.reset();
                    loadFeedback();
                    success_message.style.display = "block";
                    setTimeout(() => {
                        success_message.style.display = "none";
                    }, 3000);
                } else {
                    // handling error dari server
                    const err = await res.json().catch(() => null);
                    console.error('Server error:', err);
                }
            } catch (err) {
                console.error(err);
            } finally {
                submit_btn.disabled = false;
                submit_btn.innerText = "Kirim Feedback";
            }
        });

        loadFeedback();
    </script>
</body>

</html>
