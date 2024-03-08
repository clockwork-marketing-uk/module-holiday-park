@inject('parkAccommodationRepository', 'Clockwork\HolidayPark\Repositories\ParkAccommodationRepository')
@inject('setting', '\Clockwork\Settings\Helpers\Setting')

@extends('pages::layouts.public', ['base' => $page->base])

@php
    $parkAccommodation = $parkAccommodationRepository->all();
    $parkAccommodationTypes = $parkAccommodationRepository->getTypes();
@endphp

@section('content')
    @include('pages::templates.partials._sections', ['page' => $page])

    <div id="search-results" x-data="{ filter: 'false', tag: 'false' }" class="mb-24"
        data-query_route="{{ route('holiday-park.get-availability') }}">

        <div class="flex justify-center mb-4">
            <select name="type" id="booking-type" class="p-2 border-2">
                @foreach ($parkAccommodationTypes as $type)
                    <option value="{{ $type->booking_type }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        
        @include('availabilitysearchbar::search-bar.availability-search-bar')

        <div id="results-loading-spinner" class="flex justify-center mt-10">
            <i class="w-40 h-40 fal fa-spinner-third animate-spin"></i>
        </div>

        <div id="no-results-found-message" class="justify-center hidden text-center mt-14">
            <p>Sorry, no results found</p>
        </div>


        <div class="hidden mt-10" id="property-list">
            @include('holidaypark::holiday-park.properties.property-list', [
                'accommodation' => $parkAccommodation,
            ])
        </div>

    </div>
@endsection
