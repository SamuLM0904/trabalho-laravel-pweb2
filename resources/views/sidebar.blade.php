<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="{{ route('dashboard') }}">SIG-ACAD</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            @if (request()->routeIs('dashboard')) aria-current="page" @endif
            href="{{ route('dashboard') }}">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('aluno*') ? 'active' : '' }}"
            @if (request()->is('aluno*')) aria-current="page" @endif
            href="{{ url('aluno') }}">Aluno</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('plano*') ? 'active' : '' }}"
            @if (request()->is('plano*')) aria-current="page" @endif
            href="{{ url('plano') }}">Planos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('modalidade*') ? 'active' : '' }}"
            @if (request()->is('modalidade*')) aria-current="page" @endif
            href="{{ url('modalidade') }}">Modalidades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('avaliacao*') ? 'active' : '' }}"
            @if (request()->is('avaliacao*')) aria-current="page" @endif
            href="{{ url('avaliacao') }}">Avaliações</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('equipamento*') ? 'active' : '' }}"
            @if (request()->is('equipamento*')) aria-current="page" @endif
            href="{{ url('equipamento') }}">Equipamentos</a>
        </li>
      </ul>
      <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-outline-secondary btn-sm">Sair</button>
      </form>
    </div>
  </div>
</nav>
