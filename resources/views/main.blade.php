<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'SIG-ACAD - Gestão de Academia')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        :root {
            --sig-ink: #26352f;
            --sig-muted: #748078;
            --sig-green: #557765;
            --sig-green-dark: #456653;
            --sig-green-soft: #edf3ef;
            --sig-border: #e3e9e5;
            --sig-page: #f5f7f5;
        }

        body {
            background-color: var(--sig-page);
            color: var(--sig-ink);
        }

        header.container {
            padding-top: .75rem;
        }

        header h1 {
            color: var(--sig-ink);
            font-weight: 600;
            letter-spacing: -.02em;
        }

        .navbar {
            border-block: 1px solid var(--sig-border);
            background-color: #fff !important;
        }

        .navbar-brand {
            color: var(--sig-ink);
            font-weight: 600;
        }

        .navbar .nav-link {
            color: #5d6a62;
            font-size: .94rem;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: var(--sig-green-dark);
        }

        .navbar .nav-link.active {
            color: var(--sig-green-dark);
            font-weight: 600;
        }

        main.container {
            padding-top: 1.75rem !important;
        }

        main h2,
        main h3,
        main h4 {
            color: var(--sig-ink);
            font-weight: 600;
            letter-spacing: -.02em;
        }

        .btn {
            --bs-btn-border-radius: .45rem;
            --bs-btn-font-weight: 500;
            --bs-btn-padding-y: .45rem;
            --bs-btn-padding-x: .8rem;
        }

        .btn-primary,
        .btn-success {
            --bs-btn-color: #fff;
            --bs-btn-bg: var(--sig-green);
            --bs-btn-border-color: var(--sig-green);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--sig-green-dark);
            --bs-btn-hover-border-color: var(--sig-green-dark);
            --bs-btn-active-bg: var(--sig-green-dark);
            --bs-btn-active-border-color: var(--sig-green-dark);
        }

        .btn-danger {
            --bs-btn-bg: #b76565;
            --bs-btn-border-color: #b76565;
            --bs-btn-hover-bg: #a35454;
            --bs-btn-hover-border-color: #a35454;
            --bs-btn-active-bg: #a35454;
            --bs-btn-active-border-color: #a35454;
        }

        .btn-warning {
            --bs-btn-color: #46564c;
            --bs-btn-bg: #e8eee9;
            --bs-btn-border-color: #e8eee9;
            --bs-btn-hover-color: #34463a;
            --bs-btn-hover-bg: #dce7df;
            --bs-btn-hover-border-color: #dce7df;
            --bs-btn-active-color: #34463a;
            --bs-btn-active-bg: #dce7df;
            --bs-btn-active-border-color: #dce7df;
        }

        .btn-info {
            --bs-btn-color: #395e59;
            --bs-btn-bg: #e8f1ee;
            --bs-btn-border-color: #e8f1ee;
            --bs-btn-hover-color: #304e49;
            --bs-btn-hover-bg: #d9e9e3;
            --bs-btn-hover-border-color: #d9e9e3;
            --bs-btn-active-color: #304e49;
            --bs-btn-active-bg: #d9e9e3;
            --bs-btn-active-border-color: #d9e9e3;
        }

        .btn-outline-primary {
            --bs-btn-color: var(--sig-green-dark);
            --bs-btn-border-color: #9db4a5;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--sig-green);
            --bs-btn-hover-border-color: var(--sig-green);
            --bs-btn-active-bg: var(--sig-green-dark);
            --bs-btn-active-border-color: var(--sig-green-dark);
        }

        .btn-outline-secondary {
            --bs-btn-color: #5d6a62;
            --bs-btn-border-color: #cbd4ce;
            --bs-btn-hover-color: var(--sig-ink);
            --bs-btn-hover-bg: var(--sig-green-soft);
            --bs-btn-hover-border-color: #cbd4ce;
        }

        .form-control,
        .form-select {
            border-color: #d7dfd9;
            border-radius: .45rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #91ad9b;
            box-shadow: 0 0 0 .2rem rgba(85, 119, 101, .14);
        }

        .table-responsive {
            overflow-x: auto;
            border: 1px solid var(--sig-border);
            border-radius: .65rem;
            background-color: #fff;
        }

        .table {
            --bs-table-bg: #fff;
            --bs-table-striped-bg: #f7f9f7;
            --bs-table-hover-bg: #f1f5f2;
            --bs-table-border-color: #e8ede9;
            margin-bottom: 0;
            font-size: .92rem;
        }

        .table > :not(caption) > * > * {
            padding: .65rem .7rem;
        }

        .table thead th {
            background-color: #f5f7f5;
            color: #59675e;
            font-size: .82rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .table tbody th {
            color: var(--sig-muted);
            font-weight: 500;
        }

        .form-page {
            max-width: 960px;
            margin-inline: auto;
        }

        .form-card {
            overflow: hidden;
            border: 1px solid var(--sig-border);
            border-radius: .75rem;
            background: #fff;
            box-shadow: 0 .25rem 1rem rgba(31, 45, 61, .06);
        }

        .form-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--sig-border);
            background: #fff;
        }

        .form-card-body {
            padding: 1.5rem;
        }

        .form-card .form-label {
            margin-bottom: .4rem;
            color: #344054;
            font-weight: 500;
        }

        .form-card .form-control,
        .form-card .form-select {
            border-color: #d7dfd9;
        }

        .form-card .form-control:focus,
        .form-card .form-select:focus {
            border-color: #91ad9b;
            box-shadow: 0 0 0 .2rem rgba(85, 119, 101, .14);
        }

        .form-card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--sig-border);
        }

        @media (min-width: 768px) {
            .form-card-body {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    @auth
        <header class="container mt-3">
            <h1 class="h4 mb-3">Sistema de Gestão de Academia</h1>
        </header>
        @include('sidebar')
    @endauth

    <main class="container py-4">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert" aria-label="fechar"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert" aria-label="fechar"></button>
                </div>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <b>Por favor, verifique os erros abaixo</b>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('conteudo')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script>
        (() => {
            const maskValue = (value, type) => {
                const digits = value.replace(/\D/g, '').slice(0, type === 'cpf' ? 11 : 11);

                if (type === 'cpf') {
                    return digits
                        .replace(/^(\d{3})(\d)/, '$1.$2')
                        .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
                        .replace(/\.(\d{3})(\d)/, '.$1-$2');
                }

                if (!digits) {
                    return '';
                }

                const ddd = digits.slice(0, 2);
                const numero = digits.slice(2);
                const celular = digits.length > 10;
                const separador = celular ? 5 : 4;

                if (digits.length <= 2) {
                    return `(${ddd}`;
                }

                return `(${ddd}) ${numero.slice(0, separador)}${numero.length > separador ? `-${numero.slice(separador)}` : ''}`;
            };

            document.querySelectorAll('[data-mask]').forEach((input) => {
                const type = input.dataset.mask;
                const aplicarMascara = () => {
                    const posicao = input.selectionStart ?? input.value.length;
                    const digitosAntes = input.value.slice(0, posicao).replace(/\D/g, '').length;
                    input.value = maskValue(input.value, type);

                    let novaPosicao = 0;
                    let digitosContados = 0;
                    while (novaPosicao < input.value.length && digitosContados < digitosAntes) {
                        if (/\d/.test(input.value[novaPosicao])) {
                            digitosContados++;
                        }
                        novaPosicao++;
                    }
                    if (digitosContados === digitosAntes) {
                        while (novaPosicao < input.value.length && /\D/.test(input.value[novaPosicao])) {
                            novaPosicao++;
                        }
                    }
                    input.setSelectionRange(novaPosicao, novaPosicao);
                };

                input.addEventListener('input', aplicarMascara);
                aplicarMascara();
            });
        })();
    </script>
</body>

</html>
