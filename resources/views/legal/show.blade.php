@extends('layouts.legal')

@section('content')
    <article class="legal-document">
        @if ($html !== null)
            {!! $html !!}
        @else
            <h1>Dokumen tidak tersedia</h1>
            <p>Dokumen hukum belum dapat ditampilkan. Silakan coba lagi nanti atau hubungi devautoloker@gmail.com.</p>
        @endif
    </article>
@endsection
