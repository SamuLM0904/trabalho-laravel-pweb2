<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="{{ route('dashboard') }}">SIG-ACAD</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('aluno') }}">Aluno</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('plano') }}">Planos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('modalidade') }}">Modalidades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('avaliacao') }}">Avaliações</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('equipamento') }}">Equipamentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('curso') }}">Cursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('matricula') }}">Matrículas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
