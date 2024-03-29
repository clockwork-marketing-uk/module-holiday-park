@php
    $accommodation->base->availability_search_bar_enabled = false;
@endphp

@extends('pages::layouts.public', ['base' => $accommodation->base])

@section('title', $accommodation->base->title)

@section('content')

    <div id="holiday-park-booking-page" data-booking_id="{{ $booking->booking_no }}">
        @include('holidaypark::holiday-park.booking.partials.booking-stepper')
        <div class="stages-wrapper">
            @include('holidaypark::holiday-park.booking.partials.loading-spinner')
            @include('holidaypark::holiday-park.booking.stages.booking-info')
            @include('holidaypark::holiday-park.booking.stages.extras')
            @include('holidaypark::holiday-park.booking.stages.confirm-booking')
            @include('holidaypark::holiday-park.booking.stages.payment-info')

            @include('holidaypark::holiday-park.booking.partials.booking-summary')
        </div>

        <div class="flex justify-center" id="form-feedback">

        </div>

        <div class="booking-nav">
            <div class="nav-button btn secondary-btn" id="back-button">
                <i class="nav-icon cursor-pointer fal fa-angle-left"></i>
                <span class="button-text">Back</span>
            </div>

            <div class="nav-button btn secondary-btn" id="next-button">
                <span class="button-text">Next</span>

                <i class="nav-icon fal fa-angle-right"></i>
            </div>
        </div>


    </div>

@endsection
