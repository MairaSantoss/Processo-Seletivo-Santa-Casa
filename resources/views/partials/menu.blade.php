<style>
    .menu-icon {
        position: absolute;
        top: 0;
        left: 0;
        padding: 20px; 
        cursor: pointer;
        z-index: 999; 
    }
</style>

<nav class="white" style="margin-bottom: 30px;">
    <ul id="slide-out" class="sidenav">
        <li><div class="user-view">
            <div style="display: flex; justify-content: center; align-items: center; ">
                <a href="{{ route('santacasa.welcome') }}">
                    <img class="circle" src="{{ asset('images/santacasa.jpg') }}" alt="Santa Casa">
                </a>
            </div>
            <a href="#name"><span class="black-text name">Maíra Santos</span></a>
            <a href="#email"><span class="black-text email">mairagraziela123@hotmail.com</span></a>
        </div></li>
        <li><a href="{{ route('medicos.index') }}" class="sidenav-close"><i class="fas fa-user-md"></i> Médicos</a></li>
        <li><a href="{{ route('especialidades.index') }}" class="sidenav-close"><i class="fas fa-stethoscope"></i> Especialidades</a></li>
        <li><a href="{{ route('relatorios.relatorioMedicoEspecialidade') }}" class="sidenav-close"><i class="fas fa-chart-bar"></i> Especialidades do Médico</a></li>
        </ul>
</nav>

<a href="#" data-target="slide-out" class="sidenav-trigger menu-icon">
    <i class="material-icons" style="color: #000; font-size: 30px;">menu</i>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicialize o menu lateral
        var sidenavElem = document.querySelector('.sidenav');
        var sidenavInstance = M.Sidenav.init(sidenavElem, {});
    });
</script>
