
@extends('layoutes.crud')

@section('title', 'Especialidade')


@section('tabelaTH')
    <th>ID</th>
    <th>Nome</th>
    <th >Descrição</th>
    <th ></th>
@endsection

@section('form')
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" maxlength="45" required><br>
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" maxlength="45" required><br>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('.modal').modal();
    var table = $('.tabelaDados').DataTable({
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
    } },
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json',
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

function EnviarForm() {
    console.log($('#formdados').serialize());
    var action_url = '';
    if($('#action').val() == 'Add') { action_url = "{{ route('especialidades.store') }}"; }
    if($('#action').val() == 'Edit'){ action_url = "{{ route('especialidades.update') }}";}
    console.log($('#action').val());
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
            Regarregar();
        },
        error: function(data) {
            var errors = data.responseJSON;
            console.log(errors);
        }
    });
}

function apagarDados(){
    var id = $('#hidden_delete_id').val();
    var action_url = "{{ route('especialidades.destroy', ['id' => ':id']) }}";
    action_url = action_url.replace(':id', id);
    $.ajax({
        url: action_url,
        beforeSend:function(){
            $('#confirmDelete').text('Deletando...');
        },
        success:function(data)
        {
            Regarregar();
            $('#confirmDelete').text('Apagar');
            $('#modal2').modal('close');
        }
    })
}

function Regarregar(){
    var table = $('.tabelaDados').DataTable();
    table.ajax.reload();
}

function ModalEditar(id){
    $('#modal-dialog').html('');
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

function ModalCriar(){
    $('#modal-dialog').html('');
    $('#action').val('Add');
    $('#titulo').text("Criar");
    $('#descricao').val('');
    $('#nome').val('');
    var enviarForm = document.getElementById('enviarForm');
        enviarForm.innerText = 'Salvar'; 
        enviarForm.style.background = '#23B000'; 
        $('#modal1').modal('open');
}
</script>
@endsection