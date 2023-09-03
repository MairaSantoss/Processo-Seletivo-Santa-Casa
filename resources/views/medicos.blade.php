<!-- resources/views/medicos.blade.php  -->
@extends('layoutes.app')

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

    .voltar-btn {
        border: 1px solid #333;
        background-color: #f0f0f0;
        color: #333;
        padding: 6px 15px;
        text-decoration: none;
        border-radius: 5px;
        margin-right: 10px;
    }

    .voltar-btn:hover {
        background-color: #ddd;
    }

    .selected-container {
    display: flex;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px 10px;
    padding-top: 10px;

    margin-right: 5px;
    margin-bottom: 5px;
    font-size: 15px;
    line-height: 1.4;
}

/* Estilize o texto do item selecionado */
.selected-label {
    display: inline;
    text-align: center;
}

/* Estilize o ícone de remoção */
.remove-icon {
    margin-left: 5px;
    color: red;
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


@section('tabelaTH')
    <th>ID</th>
    <th>Nome</th>
    <th>CRM</th>
    <th ></th>
@endsection

@section('script')
<script>

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


    function EnviarForm() {
        console.log($('#formdados').serialize());
        //captura rota
        var action_url = '';
        if($('#action').val() == 'Add') { action_url = "{{ route('medicos.store') }}"; }
        if($('#action').val() == 'Edit'){ action_url = "{{ route('medicos.update') }}";}
        //captura especialidades
        var formData = $('#formdados').serializeArray();
        var arrayEspecialidades = [];
        var selectedValues = $('#especialidades').val();
        if (Array.isArray(selectedValues) && selectedValues.length > 0) {
            arrayEspecialidades = selectedValues.map(function(value) {
                return parseInt(value, 10); // Converte a string em um número inteiro
            });
        }
        formData.push({ name: "especialidades", value: JSON.stringify(arrayEspecialidades) });
        console.log(formData);
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data: formData, 
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
                    $('#formdados')[0].reset();
                    $('#medicos-table').DataTable().ajax.reload(); 
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
        limparModal();
        var action_url = "{{ route('medicos.edit', ['id' => ':id']) }}";
        action_url = action_url.replace(':id', id);
        $.ajax({
            url: action_url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function(data) {
                console.log('success:', data);
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

    function ModalApagar(id){
        $('.modal-footer').show();
        $('#hidden_delete_id').val(id);
        $('#modal2').modal('open');
    }

    function limparModal() {
        $('#formdados')[0].reset(); 
        $('#selecoes').empty(); 
        $('#especialidades').val([]); 
        $('#especialidades').formSelect(); 
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
                $('#confirmDelete').text('Apagar');
                $('#modal2').modal('close');
            }
        })
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
            processing: true,
            serverSide: true,
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
            console.log(data);
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

    $('select').formSelect(); 
    $('#especialidades').formSelect(); 
    $('#especialidades').change(function() {
        var selectedValues = $(this).val();
        previewEspecialidadesSelecionadasAtualizar(selectedValues);
    });

  /*  removeIcon.click(function() {
        console.log('a');
    });*/

}) 

function previewEspecialidadesSelecionadasAtualizar(selectedValues){
    console.log(selectedValues);
        $('select').formSelect(); 
        $('#especialidades').formSelect();
        $('#selecoes').empty();
        if (Array.isArray(selectedValues) && selectedValues.length > 0) {
            console.log('aq');
            selectedValues.forEach(function(id) {
                var label = $('select option[value="' + id + '"]').text();
                var container = $('<div class="selected-container">');
                var labelElement = $('<span class="selected-label">').text(label);
                var removeIcon = $('<a class="remove-icon" href="#"><i class="material-icons red-text">cancel</i></a>');
                /*removeIcon.click(function() {
                    container.remove();
                    var selectElement = $('#especialidades');
                    selectElement.val(selectElement.val().filter(function(value) {
                        return value !== id;
                    }));
                    selectElement.formSelect(); 
                });*/
                container.append(labelElement);
                container.append(removeIcon);
                $('#selecoes').append(container);
            });
        }
    }

</script>
@endsection




