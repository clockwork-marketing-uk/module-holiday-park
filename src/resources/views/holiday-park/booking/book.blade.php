@extends('pages::layouts.public', ['base' => $accommodation->base])

@section('title', $accommodation->base->title)

@section('content')

    <h1>BOOK NOWW</h1>

    @php
        echo "<pre>".json_encode($stay, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."</pre>";
    @endphp

@endsection
