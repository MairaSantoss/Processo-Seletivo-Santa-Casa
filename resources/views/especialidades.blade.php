
@extends('layoutes.app')

@section('title', 'Especialidade')

@section('content')

@endsection


@section('form')

    <div>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" maxlength="45" required>
    </div>
    <div>
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" maxlength="45" required>
    </div>
@endsection