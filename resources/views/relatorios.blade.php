
@extends('layoutes.relatorio')

@section('title', 'Especialidade dos médico')

@section('filtro')

    <div class="input-field col s12 m6 l3">
        <select name="especialidades" id="especialidades" class="browser-default selectmodal" style="display:block; width: 100%; " >
            <!-- Adicione as opções de especialidade aqui -->
        </select>
    </div>
    <div class="input-field col s12 m6 l3">
        <select id="crmMedico" name="crm_medico" class="browser-default selectmodal" style="display:block; width: 100%; ">
        <!-- As opções serão preenchidas via AJAX -->
        </select>
    </div>
@endsection

@section('tabelaTH')
    <th>ID</th>
    <th>Nome</th>
    <th>CRM</th>
    <th>Especialidades</th>
    <th></th>
@endsection

@section('modalRead')
    <div class="row user-view">
        <img style="width: 60px;"  src="{{ asset('images/user.png') }}">
        
        <a href="#name"><span class="black-text name"><h5><b id="medicoNome"></b></h5></span></a>
        <a href="#email"><span class="black-text email">mairagraziela123@hotmail.com</span></a>
    </div>

    <h6><b>Médico</b></h6>
    <p>ID: <span id="medicoId"></span></p>
    <p>CRM: <span id="medicoCRM"></span></p>
    <p>Email: <span id="medicoEmail"></span></p>
    <p>Telefone: <span id="medicoTelefone"></span></p>
    <p>Data de Cadastro: <span id="medicoDataCadastro"></span></p>
    <h6><b>Especialidades:</b></h6>
    <ul id="especialidadesList"></ul>
@endsection

@section('script')
<script>
var table;
$(document).ready(function() {
    $('.modal').modal();
    $(".selectmodal").select2();

    $.ajax({
        url: '{{ route("especialidades.select") }}', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            var selectEspecialidades = $('#especialidades');
            selectEspecialidades.empty(); 
            selectEspecialidades.append('<option disabled selected>Selecione uma especialidade</option>');
            $.each(data, function(index, especialidade) {
                selectEspecialidades.append($('<option>', {
                    value: especialidade.id,
                    text: '(' + especialidade.id + ')  ' + especialidade.nome
                }));
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

    $.ajax({
        url: '{{ route("medicos.selectCRM") }}', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            var selectCRM = $('#crmMedico');
            selectCRM.empty();
            selectCRM.append('<option disabled selected>Selecione um CRM</option>');
            $.each(data, function(index, medico) {
                selectCRM.append($('<option>', {
                    value: medico,
                    text: medico
                }));
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

    table = $('.tabelaDados').DataTable({
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
        ajax: "{{ route('relatorios.relatorioMedicoEspecialidade') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'nome', name: 'nome'},
            {data: 'CRM', name: 'CRM'},
            {data: 'especialidades', name: 'especialidades'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

});

function VisualizarTudo(id){
    var action_url = "{{ route('medicos.edit', ['id' => ':id']) }}";
    action_url = action_url.replace(':id', id);
    $.ajax({
        url: action_url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        success: function(data) {
            var result = data.result;
            var especialidades = data.result2;
            $('#medicoId').text(result.id);
            $('#medicoNome').text(result.nome);
            $('#medicoCRM').text(result.CRM);
            $('#medicoEmail').text(result.email);
            $('#medicoTelefone').text(result.telefone);
            $('#medicoDataCadastro').text(result.dt_cadastro);
            $('#especialidadesList').empty();
            especialidades.forEach(function(especialidade) {
                var li = $('<li>').text(  especialidade.nome + ' - ' + especialidade.descricao);
                $('#especialidadesList').append(li);
            });
            $('#modal3').modal('open');
        },
        error: function(data) {
            var errors = data.responseJSON;
            console.log(errors);
        }
    });
}

function Filtrar() {
    if ($.fn.DataTable.isDataTable('.tabelaDados')) {
    $('.tabelaDados').DataTable().destroy();
}

    var crmMedicoSelecionado = $('#crmMedico').val();
    var especialidadeSelecionada = $('#especialidades').val();

    // Construa a URL da rota com os parâmetros de filtro
    var action_url = "{{ route('relatorios.filtroRelatorio', ['crm_medico' => ':crm_medico', 'especialidades' => ':especialidades']) }}"
    .replace(':crm_medico', crmMedicoSelecionado)
    .replace(':especialidades', especialidadeSelecionada);

    $('#tabelaDados').DataTable({
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
        ajax: action_url,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'nome', name: 'nome'},
            {data: 'CRM', name: 'CRM'},
            {data: 'especialidades', name: 'especialidades'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

function Limpar(){
    location.reload();
}
</script>
@endsection