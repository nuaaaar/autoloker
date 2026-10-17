<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    @if ($canonical)
        <link rel="canonical" href="{{ $canonical }}">
    @endif
    <link rel="icon" href="{{ asset('/assets/media/logos/autoloker-logo-small.png') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/legal.css') }}">
</head>
<body class="legal-page">
    <a class="legal-skip" href="#legal-main">Lewati ke dokumen</a>
    <header class="legal-header">
        <a class="legal-brand" href="{{ route('legal.privacy-policy', [], false) }}" aria-label="Autoloker">
            <img src="{{ asset('/assets/media/logos/autoloker-logo.png') }}" alt="Autoloker" width="180">
        </a>
    </header>
    <main id="legal-main" class="legal-main">
        @yield('content')
    </main>
    <footer class="legal-footer">
        <nav aria-label="Tautan dokumen hukum">
            <a href="{{ route('legal.privacy-policy', [], false) }}">Kebijakan Privasi</a>
            <a href="{{ route('legal.terms-and-conditions', [], false) }}">Syarat dan Ketentuan</a>
            <a href="mailto:devautoloker@gmail.com">devautoloker@gmail.com</a>
        </nav>
    </footer>
</body>
</html>
