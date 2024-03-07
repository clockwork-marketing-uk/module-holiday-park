@extends('pages::layouts.public', ['base' => $accommodation->base])

@section('title', $accommodation->base->title)

@section('content')

    <h1>BOOK NOW</h1>
    {{-- @include('pages::templates.partials._sections', ['page' => $accommodation]) --}}

@endsection
