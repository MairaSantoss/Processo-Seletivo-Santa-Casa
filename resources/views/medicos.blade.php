<!-- resources/views/medicos.blade.php  -->
@extends('layoutes.crud')

@section('title', 'Médico')

@section('tabelaTH')
    <th>ID</th>
    <th>Nome</th>
    <th>CRM</th>
    <th ></th>
@endsection

@section('form')
<style>
    .select2-selection__rendered{
        display: none !important;
    }
</style>
<div id="especialidade1">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" maxlength="45" required><br>

    <label for="CRM">CRM:</label>
    <input type="text" id="CRM" name="CRM" maxlength="45" required><br>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" maxlength="45" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" maxlength="45" required><br> 

    <div class="center" style="margin-top: 30px;">
        <a href="#" onclick="MostrarAba(2)" class="voltar-btn">PRÓXIMO</a>
    </div>
</div>

<div id="especialidade2">
    <div style="margin-bottom: 150px" >
    <label for="especialidades">Selecione a especialidade:</label>
    <br> 
    <select class="browser-default selectmodal" style="display:block; width: 100%; " name="especialidades[]" id="especialidades" multiple required>
    </select>
    <br>  
    <label for="especialidades">Especialidades:</label> <br> 
    <div id="selecoes" style="display: flex;"></div>
    </div>
    <div class="center" style="margin-top: 30px;">
        <a href="#" style="color: #000;text-decoration:underline;" onclick="MostrarAba(1)">VOLTAR</a>
    </div>
</div>
@endsection

@section('modalRead')
    <div class="row">
        <img style="width: 100px;"  class="col s12 m12 l6" src="{{ asset('images/user.png') }}">
        <div class="col s12 m12 l6">
            <h6><b id="medicoNome"></b></h6>
            <p>CRM: <span id="medicoCRM"></span></p>
        </div>
    </div>
    <p>Email: <span id="medicoEmail"></span></p>
    <p>Telefone: <span id="medicoTelefone"></span></p>
    <p>Data de Cadastro: <span id="medicoDataCadastro"></span></p>
    <h6><b>Especialidades:</b></h6>
    <ul id="especialidadesList"></ul>
@endsection

@section('script')
<script>
    function EnviarForm() {
        var action_url = '';
        if($('#action').val() == 'Add') { action_url = "{{ route('medicos.store') }}"; }
        if($('#action').val() == 'Edit'){ action_url = "{{ route('medicos.update') }}";}
        //captura especialidades
        var formData = $('#formdados').serializeArray();
        var arrayEspecialidades = [];
        var selectedValues = $('#especialidades').val();
        if (Array.isArray(selectedValues) && selectedValues.length > 0) {
            arrayEspecialidades = selectedValues.map(function(value) {
                return parseInt(value, 10); 
            });
        }
        formData.push({ name: "especialidades", value: JSON.stringify(arrayEspecialidades) });
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data: formData, 
            dataType: 'json',
            success: function(data) {
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
                    $('#formdados')[0].reset();
                    $('#medicos-table').DataTable().ajax.reload(); 
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

    function ModalEditar(id){
        limparModal();
        var action_url = "{{ route('medicos.edit', ['id' => ':id']) }}";
        action_url = action_url.replace(':id', id);
        $.ajax({
            url: action_url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function(data) {
                $('#nome').val(data.result.nome);
                $('#CRM').val(data.result.CRM);
                $('#telefone').val(data.result.telefone);
                $('#email').val(data.result.email);
                $('#hidden_id').val(id);
                $('#action').val('Edit');
                //monta o input seletor do modal
                var especialidadesMedico = data.result2; 
                var idsEspecialidadesMedico = especialidadesMedico.map(function(especialidade) {
                    return especialidade.id;
                });
                idsEspecialidadesMedico.forEach(function(id) {
                    $('#especialidades option[value="' + id + '"]').prop('selected', true);
                });
                previewEspecialidadesSelecionadasAtualizar(idsEspecialidadesMedico);
                //edita label do modal
                $('#titulo').text("Editar");
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

    function apagarDados(){
        var id = $('#hidden_delete_id').val();
        var action_url = "{{ route('medicos.destroy', ['id' => ':id']) }}";
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

    function previewEspecialidadesSelecionadasAtualizar(selectedValues){
        $('select').formSelect(); 
        $('#especialidades').formSelect();
        $('#selecoes').empty();
        if (Array.isArray(selectedValues) && selectedValues.length > 0) {
            selectedValues.forEach(function(id) {
                var label = $('select option[value="' + id + '"]').text();
                var container = $('<div class="selected-container">');
                var labelElement = $('<span class="selected-label">').text(label);
                container.append(labelElement);
                $('#selecoes').append(container);
            });
        }
    }

    function ModalApagar(id){
        $('.modal-footer').show();
        $('#hidden_delete_id').val(id);
        $('#modal2').modal('open');
    }

    function ModalCriar(){
        limparModal();
        $('#action').val('Add');
        $('#titulo').text("Criar");
        var enviarForm = document.getElementById('enviarForm');
            enviarForm.innerText = 'Salvar'; 
            enviarForm.style.background = '#23B000'; 
            $('#modal1').modal('open');
    }

    function limparModal() {
        $('#modal-dialog').html('');
        $('#formdados')[0].reset(); 
        $('#selecoes').empty(); 
        $('#especialidades').val([]); 
        $('#especialidades').formSelect(); 
    }

    function Regarregar(){
        var table = $('.tabelaDados').DataTable();
        table.ajax.reload();
    }

$(document).ready(function() {
    $('.modal').modal();
    $(".selectmodal").select2({ dropdownParent: $("#modal1"), });
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
        }
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json',
        },
        processing: true,
        serverSide: true,
        lengthMenu: [],
        ajax: "{{ route('medicos.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'nome', name: 'nome'},
            {data: 'CRM', name: 'CRM'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $.ajax({
        url: '{{ route("especialidades.select") }}', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var selectEspecialidades = $('#especialidades');
            selectEspecialidades.empty(); 
            $.each(data, function(index, especialidade) {
                selectEspecialidades.append($('<option>', {
                    value: especialidade.id,
                    text: especialidade.nome
                }));
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

    $('#especialidades').change(function() {
        var selectedValues = $(this).val();
        previewEspecialidadesSelecionadasAtualizar(selectedValues);
    });

}) 

$('#especialidade2').hide();
$('.modal-footer').hide();

function MostrarAba(aba) {
    $('#especialidade1').hide();
    $('#especialidade2').hide();
    $(`#especialidade${aba}`).show();
    $('.modal-footer').hide();
    if(aba == 2)
    $('.modal-footer').show();
}

</script>
@endsection




