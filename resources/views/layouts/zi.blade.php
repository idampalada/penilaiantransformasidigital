<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>e-Monitoring Reformasi Birokrasi</title>

    {{-- BOOTSTRAP 3 --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-color: #f5f6f7;
            font-size: 12px;
        }

        /* HEADER TABLE */
        .zi-table thead th {
            background: #003366;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        /* SECTION */
        .zi-section {
            background: #00a2e8;
            color: #fff;
            font-weight: bold;
        }

        .zi-subsection {
            background: #8ee7ff;
            font-weight: bold;
        }

        .zi-table td, .zi-table th {
            border: 1px solid #ccc !important;
            vertical-align: top;
        }

        .zi-input {
            width: 60px;
            text-align: center;
        }

        .btn-excel {
            background: #f0ad4e;
            color: #000;
            font-weight: bold;
        }

        .zi-cell-split > div {
    padding: 6px;
}

.zi-cell-split > div + div {
    border-top: 1px solid #999;
}

    </style>
</head>
<body>

<div class="container-fluid">
    @yield('content')
</div>

</body>
</html>
