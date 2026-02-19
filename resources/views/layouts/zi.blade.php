<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Penilaian Transformasi Digital</title>

    {{-- BOOTSTRAP 3 --}}
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    {{-- FONT AWESOME --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- CSS --}}        
    <link rel="stylesheet" href="{{ asset('css/unor.css') }}">


    
</head>
<body>

<div class="container-fluid">
    @yield('content')
</div>

{{-- SCRIPT --}}   
<script src="{{ asset('js/unor.js') }}"></script>

</body>
</html>
