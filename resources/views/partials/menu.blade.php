<nav>
    <!-- navbar content here -->

    <ul id="slide-out" class="sidenav sidenav-fixed">

    <li><div class="user-view">

        <a class=" row center" href="#user"><img class="circle" src="{{ asset('images/user.png') }}"></a>

        <a href="#name"><span class="black-text name">Maíra Santos</span></a>
        <a href="#email"><span class="black-text email">mairagraziela123@hotmail.com</span></a>
    </div></li>

        <li><a href="{{ route('medicos.index') }}"><i class="fas fa-user-md"></i> Médicos</a></li>
        <li><a href="{{ route('especialidades.index') }}"><i class="fas fa-stethoscope"></i> Especialidades</a></li>
        <li><a href="{{ route('medico_especialidades.index') }}"><i class="fas fa-chart-bar"></i> Especialidades do Médico</a></li>
    </ul>

    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidenavElem = document.querySelector('.sidenav');
        var sidenavInstance = M.Sidenav.init(sidenavElem, {});
        
        if (window.innerWidth < 992) { // 992 é a largura para tablets
            sidenavInstance.close();
        }
    });
</script>
