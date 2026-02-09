<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>e-Monitoring Reformasi Birokrasi</title>

    {{-- BOOTSTRAP 3 --}}
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-color: #f5f6f7;
            font-size: 12px;
        }

        /* ==========================
           TABLE GLOBAL
        ========================== */
        .zi-table {
            background: #fff;
            width: 100%;
            table-layout: fixed; /* KUNCI LAYOUT */
        }

        .zi-table th,
        .zi-table td {
            border: 1px solid #ccc !important;
            vertical-align: top !important;
            padding: 6px 8px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* ==========================
           TABLE HEADER
        ========================== */
        .zi-table thead th {
            background: #003366;
            color: #fff;
            text-align: center;
            vertical-align: middle !important;
            font-weight: bold;
        }

        /* ==========================
           INNER SPLIT TABLE
        ========================== */
        .zi-inner-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .zi-inner-table td {
            border: 1px solid #bbb;
            padding: 6px;
            vertical-align: top;
            line-height: 1.4;
            word-wrap: break-word;
            white-space: normal;
        }

        /* HILANGKAN DOUBLE BORDER */
        .zi-table td[colspan] {
            padding: 0 !important;
        }

        /* ==========================
           INPUT & FILE
        ========================== */
        .zi-input {
            width: 60px;
            height: 30px;
            text-align: center;
            padding: 4px;
            font-size: 12px;
        }

        .zi-file-input {
            width: 100%;
            font-size: 11px;
        }
        /* ================= GROUP HEADER ================= */
.zi-group-header td {
    background: #0099FF; /* biru tua */
    color: #fff;
    font-weight: bold;
    text-align: center;
    font-size: 13px;
    padding: 8px;
}


    </style>
    
</head>
<body>

<div class="container-fluid">
    @yield('content')
</div>

</body>
</html>
