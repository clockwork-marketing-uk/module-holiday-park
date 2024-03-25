@inject('parkAccommodationRepository', 'Clockwork\HolidayPark\Repositories\ParkAccommodationRepository')
@inject('setting', '\Clockwork\Settings\Helpers\Setting')

@extends('pages::layouts.public', ['base' => $page->base])

@php
    $parkAccommodation = $parkAccommodationRepository->all();
    $parkAccommodationTypes = $parkAccommodationRepository->getTypes();
@endphp

@section('content')
    @include('pages::templates.partials._sections', ['page' => $page])

    <div id="search-results" x-data="{ filter: 'false', tag: 'false' }" class="search-results-template"
        data-query_route="{{ route('holiday-park.get-availability') }}">

        <div class="select-container">
            <select name="type" id="booking-type" class="select-box">
                @foreach ($parkAccommodationTypes as $type)
                    <option {{ $type->booking_type == request()->query('booking_type') ? "selected" : "" }} value="{{ $type->booking_type }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        @include('availabilitysearchbar::search-bar.availability-search-bar')

        <div id="results-loading-spinner" class="results-spinner">
            <i class="spinner-icon fal fa-spinner-third animate-spin"></i>
        </div>

        <div id="no-results-found-message" class="hidden no-results">
            <p>Sorry, no results found</p>
        </div>


        <div class="hidden property-list" id="property-list">
            @include('holidaypark::holiday-park.properties.property-list', [
                'accommodation' => $parkAccommodation,
            ])
        </div>

    </div>
@endsection
