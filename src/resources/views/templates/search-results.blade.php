@inject('parkAccommodationRepository', 'Clockwork\HolidayPark\Repositories\ParkAccommodationRepository')
@inject('setting', '\Clockwork\Settings\Helpers\Setting')

@extends('pages::layouts.public', ['base' => $page->base])

@php
    $parkAccommodation = $parkAccommodationRepository->all();
    $parkAccommodationTypes = $parkAccommodationRepository->getTypes();
@endphp

@section('content')
    @include('pages::templates.partials._sections', ['page' => $page])

    <div id="search-results" x-data="{ filter: 'false', tag: 'false' }" class="mb-24" data-query_route="{{ route('holiday-park.get-availability') }}">

        <select name="type" id="booking-type">
            @foreach ($parkAccommodationTypes as $type)
                <option value="{{ $type->booking_type }}">{{ $type->name }}</option>
            @endforeach
        </select>
        


        @include('availabilitysearchbar::search-bar.availability-search-bar')

        <div id="results-loading-spinner" class="flex justify-center mt-10">
            <i class="w-40 h-40 fal fa-spinner-third animate-spin"></i>
        </div>
        
        
        <div class="hidden" id="property-list">
            @include('holidaypark::holiday-park.properties.property-list', [
                'accommodation' => $parkAccommodation,
            ])
        </div>
        
    </div>
@endsection
