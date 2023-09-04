<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Santa Casa</title>
        
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- css - UI -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}" media="screen,projection">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<style>
        .content {
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
    
<body>
    
    @include('partials.menu')
    <div class="content">
        <p style="color: #02e502; font-weight: bold; font-size: 17px;">Bem-vindo</p>
        <p style="color: #797979 ; font-weight: bold; font-size: 15px;">Portal Santa Casa - Tecnologia e produtividade</p>
    </div>
    
    <div class="content">
        <img  src="{{ asset('images/santacasa.jpg') }}">
    </div>

    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>

</body>
</html>

