@inject('arr', 'Illuminate\Support\Arr')
@inject('parkBooking', 'Clockwork\HolidayPark\Models\ParkBooking')
@inject('parkAccommodation', 'Clockwork\HolidayPark\Models\ParkAccommodation')

@php
    $parkBookingModel = $parkBooking::where('booking_no', '=', $threeDSSessionData['bookingId'])->first();
    $parkAccommodationModel = $parkAccommodation::with('accommodation')->find($parkBookingModel->park_accommodation_id);
    $base = $parkAccommodationModel->accommodation->first()->base()->first();
    $threeDSSessionData = $arr::query($threeDSSessionData);
    $threeDSSessionData = base64_encode($threeDSSessionData);
@endphp

@extends('pages::layouts.public', ['base' => $base])

@section('title', '3d Secure Authentication')

@section('content')
<div class="flex justify-center w-full mt-24">
    <form action="{{ $acsUrl }}" method="post">
        <input type="hidden" name="creq" value="{{ $creq }}" />     
        <input type="hidden" name="threeDSSessionData" value="{{ $threeDSSessionData }}" />     
        <p>Please click button below to proceed to 3D secure.</p>
        <input type="submit" value="Go"/>   
    </form>
</div>
    
@endsection
