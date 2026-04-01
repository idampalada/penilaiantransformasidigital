<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Unit</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 30px 20px;
        }

        .unit-wrapper {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .unit-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 28px 32px 32px;
            width: 380px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        }

        .unit-card h4 strong {
            color: #1a2e4a;
            font-size: 17px;
        }

        .unit-card p strong {
            color: #333;
            font-size: 13px;
        }

        hr {
            border-top: 1px solid #ddd;
            margin: 12px 0 20px;
        }

        .label-unit {
            font-size: 11px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 14px;
            display: block;
        }

        .btn-unit {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 3px;
            text-align: center;
            text-decoration: none;
            color: #fff !important;
            border: none;
            transition: background-color 0.15s ease;
        }

        .btn-unit:last-child { margin-bottom: 0; }

        /* Palet #003366 · #0099FF · #CCEAFF */
        .btn-unor  { background-color: #003366; }
        .btn-unor:hover  { background-color: #004080; }

        .btn-unker { background-color: #0099FF; }
        .btn-unker:hover { background-color: #007acc; }

        .btn-upt   { background-color: #CCEAFF; color: #003366 !important; }
        .btn-upt:hover   { background-color: #b3deff; }
    </style>
</head>
<body>

<div class="unit-wrapper">
    <div class="unit-card">

        <h4><strong>PENILAIAN TRANSFORMASI DIGITAL</strong></h4>
        <p><strong>PUSAT DATA DAN TEKNOLOGI INFORMASI</strong></p>

        <hr>

        <span class="label-unit">Pilih Unit Penilaian</span>

        <a href="/set-unit/unor"  class="btn-unit btn-unor">UNOR</a>
        <a href="/set-unit/unker" class="btn-unit btn-unker">UNKER</a>
        <a href="/set-unit/upt"   class="btn-unit btn-upt">UPT</a>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>