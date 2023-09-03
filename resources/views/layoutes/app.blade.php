
  <!--   <link rel="stylesheet" href="{{ asset('css/menu.css') }}">  Exemplo: substitua 'css/app.css' pelo caminho correto do seu CSS -->

<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')s - Santa Casa</title>
        
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- datatable -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- datatable responsive -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <!-- css - UI -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}" media="screen,projection">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    
    @include('partials.menu')

    <div class="row container">
        <table class="tabelaDados table-reponsive " style="width:100%">
            <thead>
                <tr>
                    @yield('tabelaTH')
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="botaoAdiconarCadastro">
        <a class=" btn-floating btn-large waves-light btn "
            style="background-color:#23B000; margin-top: 1%; float:right;" onclick="ModalCriar();"><i
                class="material-icons">add</i></a>
    </div>

    <div id="modal1" class="modal">
    <div id="modal-dialog"></div>
        <form method="post"  action='' id="formdados">
            @csrf
            <div class="modal-content">
                <h5><span id='titulo'></span> @yield('title')</h5>
                @yield('form')
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="hidden" name="action" id="action" />
            </div>
            <div class="modal-footer">
                <div class="center">
                    <a id="enviarForm" onclick="EnviarForm();" class="waves-light btn" style="background: #23B000;border-radius: 6px;"><a>
                    <a class="waves-light btn modal-close" style="background: #5C5C5C;border-radius: 6px;">Fechar</a>
                </div>
            </div>
        </form>
    </div>

    <div id="modal2" class="modal">
        <div class="modal-content">
            <h5>Confirmar Exclusão</h5>
            <p>Tem certeza de que deseja apagar os dados?</p>
            <input type="hidden" name="hidden_delete_id" id="hidden_delete_id" />
        </div>
        <div class="modal-footer">
            <div class="center">
                <a id="confirmDelete" onclick="apagarDados();" class="waves-light btn" style="background: #FF5733;border-radius: 6px;">Apagar</a>
                <a class="waves-light btn modal-close" style="background: #5C5C5C;border-radius: 6px;">Cancelar</a>
            </div>
        </div>
    </div>

    <footer>
        <p>© {{ date('Y') }} Todos os direitos reservados.</p>
    </footer>
 
    <!-- request e acoes -->
    @yield('script')
    <!-- js  -->
    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    <!-- datatable -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <!-- select com pesquisa -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>
</html>

