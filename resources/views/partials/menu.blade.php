<!-- resources/views/partials/menu.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Meu Projeto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('medicos.index') }}">Médicos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('especialidades.index') }}">Especialidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('medico_especialidades.index') }}">Especialidades do Médico</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
