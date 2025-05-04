<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Dalam Perbaikan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        img {
            width: 250px;
            max-width: 80%;
            animation: bounce 2s infinite;
        }

        h1 {
            color: #e74c3c;
            font-size: 32px;
            margin-top: 20px;
        }

        p {
            font-size: 18px;
            max-width: 400px;
            color: #555;
            margin-bottom: 50px;
        }

        .footer {
            font-size: 14px;
            color: #aaa;
            position: absolute;
            bottom: 20px;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 26px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png" alt="Maintenance Image">

    <h1>Mohon Maaf!</h1>
    <p>Halaman ini sedang dalam perbaikan untuk pengalaman yang lebih baik. Silakan kunjungi kembali nanti.</p>

    <div class="footer">© <?= date('Y') ?> Kaukabapay. Semua hak dilindungi.</div>

</body>
</html>
