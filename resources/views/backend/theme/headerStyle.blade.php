<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@yield('title') - AdminPanel </title>
    <link rel="shortcut icon" href="{{ asset('assets/admin/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('assets/admin/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/admin/media/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="stylesheet" id="css-main" href=" {{ asset('assets/admin/css/oneui.min.css') }}">
    {{-- Notify Css --}}
    @notifyCss

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Start Data Table Css --}}
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('new/jquery.dataTables.min.css') }}" />
    <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet'
        type='text/css'>
    {{-- End Data Table Css --}}

    {{-- Start Custome Css Add --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/custome/custome.css') }}" />
    {{-- End Custome Css Add --}}
    @yield('styles')
</head>
