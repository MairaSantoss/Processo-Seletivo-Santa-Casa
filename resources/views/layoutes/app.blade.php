
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

    <div class="content">
        @yield('content')
    </div>

    <div class="row container">
        <table class="especialidades table-reponsive " style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                    <th >Action</th>

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
                <a id="enviarForm" onclick="EnviarForm('create');" class="waves-light btn" style="background: #23B000;border-radius: 6px;"><a>
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
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <a class="waves-light btn modal-close" style="background: #5C5C5C;border-radius: 6px;">Cancelar</a>
            </div>
        </div>
    </div>

    <script>

 $('#ok_button').click(function(){
        $.ajax({
            url:"especialidades/destroy/"+1,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#user_table').DataTable().ajax.reload();
                alert('Data Deleted');
                }, 2000);
            }
        })
    });

function enviarForm() {
    console.log($('#formdados').serialize());
    var action_url = '';
    if($('#action').val() == 'Add') { action_url = "{{ route('especialidades.store') }}"; }
    if($('#action').val() == 'Edit'){ action_url = "{{ route('especialidades.update') }}";}
    // create 
    $.ajax({
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: action_url,
        data: $('#formdados').serialize(), 
        dataType: 'json',
        success: function(data) {
            console.log('success:', data);
            var html = '';
            if (data.errors) {
                html = '<div style="background-color:#FF6347;">';
                for (var count = 0; count < data.errors.length; count++) {
                    html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
            }
            if (data.success) {
                html = '<div style="background-color:#3CB371;">' + data.success + '</div>';
                $('#formdados')[0].reset(); // Resetando o formulário
                $('#especialidades-table').DataTable().ajax.reload(); // Alterado aqui para refletir a tabela
            }
            $('#modal-dialog').html(html);
        },
        error: function(data) {
            var errors = data.responseJSON;
            console.log(errors);
        }
    });
}

function ModalEditar(id){
    var action_url = "{{ route('especialidades.edit', ['id' => ':id']) }}";
    action_url = action_url.replace(':id', id);
    $.ajax({
        url: action_url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        success: function(data) {
            console.log('success:', data);
            $('#nome').val(data.result.nome);
            $('#titulo').text("Editar");
            $('#hidden_id').val(id);
            $('#descricao').val(data.result.descricao);
            $('#action').val('Edit');
            var enviarForm = document.getElementById('enviarForm');
            enviarForm.innerText = 'Editar'; 
            enviarForm.style.background = 'orange'; 
            $('#modal1').modal('open');
        },
        error: function(data) {
            var errors = data.responseJSON;
            console.log(errors);
        }
    });
}

    function ModalApagar(id){
        $('#hidden_delete_id').val(id);
        $('#modal2').modal('open');
    }

    function apagarDados(){
        var action_url = "{{ route('especialidades.edit', ['id' => ':id']) }}";
        action_url = action_url.replace(':id', id);
            $.ajax({
                url:"users/destroy/"+user_id,
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
                success:function(data)
                {
                    setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#user_table').DataTable().ajax.reload();
                    alert('Data Deleted');
                    }, 2000);
                }
            })
    }

    function ModalCriar(){
        $('#action').val('Salvar');
        $('#titulo').text("Criar");
        $('#descricao').val('');
        $('#nome').val('');
        var enviarForm = document.getElementById('enviarForm');
            enviarForm.innerText = 'Salvar'; 
            enviarForm.style.background = '#23B000'; 
            $('#modal1').modal('open');
    }

    $(document).ready(function() {
        $('.modal').modal();
        var table = $('.especialidades').DataTable({

        responsive: {
        breakpoints: [
            { name: 'bigdesktop', width: Infinity },
            { name: 'meddesktop', width: 1480 },
            { name: 'smalldesktop', width: 1280 },
            { name: 'medium', width: 1188 },
            { name: 'tabletl', width: 1024 },
            { name: 'btwtabllandp', width: 848 },
            { name: 'tabletp', width: 768 },
            { name: 'mobilel', width: 480 },
            { name: 'mobilep', width: 320 }
        ], details: {
            renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
                return col.hidden ?
                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                '<td><b>' + col.title + '</b>:' + '</td> ' +
                '<td>' + col.data + '</td>' +
                '</tr>' :
                '';
            }).join('');

            return data ?
                $('<table/>').append(data) :
                false;
            }
        }
        },
            processing: true,
            serverSide: true,
            ajax: "{{ route('especialidades.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nome', name: 'nome'},
                {data: 'descricao', name: 'descricao'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }) 

    </script>

    <footer>
        <p>© {{ date('Y') }} Todos os direitos reservados.</p>
    </footer>
 
    <!-- js  -->
    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    <!-- datatable -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
</body>
</html>

