@php
    $accommodation->base->availability_search_bar_enabled = false;
@endphp

@extends('pages::layouts.public', ['base' => $accommodation->base])

@section('title', $accommodation->base->title)

@section('content')

    <div id="holiday-park-booking-page" data-booking_id="{{ $booking }}" class="mt-10">
        @include('holidaypark::holiday-park.booking.partials.booking-stepper')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
            @include('holidaypark::holiday-park.booking.partials.booking-summary')
            
            @include('holidaypark::holiday-park.booking.partials.loading-spinner')
            @include('holidaypark::holiday-park.booking.stages.booking-info')
            @include('holidaypark::holiday-park.booking.stages.extras')
            @include('holidaypark::holiday-park.booking.stages.confirm-booking')
            @include('holidaypark::holiday-park.booking.stages.payment-info')
        </div>

        <div class="flex justify-center my-6 gap-x-4">
            <div class="flex flex-row bg-gray-300 cursor-pointer btn" id="back-button">
                <i class="my-auto cursor-pointer fal fa-arrow-left-long"></i>
                <div class="ml-2 button-text">
                    Back
                </div>
            </div>
            <div class="flex flex-row cursor-pointer btn secondary-btn" id="next-button">
                <div class="mr-2 button-text">
                    Next
                </div>
                <i class="my-auto cursor-pointer fal fa-arrow-right-long"></i>
            </div>
        </div>
    </div>

@endsection
