<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    {{-- ✅ SELECT2 CSS (FIXED, NO 404) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>

<body>

<div class="container-fluid">
    @yield('content')
</div>

{{-- ================= SCRIPT ================= --}}

{{-- ✅ jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- ✅ Select2 JS (FIXED, NO 404) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

{{-- ✅ INIT --}}
<script>
$(document).ready(function () {
    if ($.fn.select2) {
        $('.select2').select2({
            placeholder: "-- Pilih Unit --",
            allowClear: true,
            width: '100%'
        });
    } else {
        console.error('Select2 gagal load');
    }
});
</script>

{{-- SCRIPT KAMU --}}
<script src="{{ asset('js/unor.js') }}"></script>

</body>
</html>