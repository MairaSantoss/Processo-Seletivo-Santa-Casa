<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>@yield('title')s - Santa Casa</title>
        
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- datatable -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- datatable responsive -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <!-- css - UI -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/crud.css') }}"  />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}" media="screen,projection">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        img {
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        .content {

        }
    </style>
</head>
<body>

    @include('partials.menu')


    <div class="content">
        <p style="color: green; font-weight: bold;">Bem-vindo</p>
        <p>Esta é a minha página inicial personalizada.</p>
    </div>
    <img  src="{{ asset('images/santacasa.jpg') }}">

    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>

</body>
</html>
