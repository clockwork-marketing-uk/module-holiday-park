<div id="confirm-booking" class="hidden" data-get_booking_route="{{ route('holiday-park.booking.get-booking') }}" data-tag_booking_route="{{ route('holiday-park.booking.tag-booking') }}">
    <div id="confirmation-content">
        @include('pages::templates.partials._sections', ['page' => $confirmationPage])
    </div>
</div>