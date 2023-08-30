<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- Incluir o CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}"> <!-- Exemplo: substitua 'css/app.css' pelo caminho correto do seu CSS -->
    
    <!-- Incluir o Font Awesome (caso não esteja usando outra fonte de ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Incluir outros estilos se necessário -->

    <!-- Incluir scripts JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script> <!-- Exemplo: substitua 'js/app.js' pelo caminho correto do seu JavaScript -->
    <!-- Incluir outros scripts se necessário -->
</head>
<body>
    
    @include('partials.menu')

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>© {{ date('Y') }} Todos os direitos reservados.</p>
    </footer>
</body>
</html>
