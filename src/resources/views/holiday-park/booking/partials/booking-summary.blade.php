@inject('FormatDateHelper', '\Clockwork\HolidayPark\Helpers\FormatDateHelper')

<div id="booking-summary">
    <div class="inner-wrap">
        <div class="section-heading">
            <h2 class="title">Reservation Details</h2>
            <p class="text">You would like to make the following reservation.</p>
        </div>

        <div class="accommodation-type">
            @imageLazy($accommodation->images[0], ['class' => 'w-full h-auto'])
            <div class="selected-accommodation">
                <h4 class="title">{{ $accommodation->base->title }}</h4>
                <p class="category">Category</p>
            </div>
        </div>

        <div class="options-list">
            <div class="reservation-option">
                <strong>Arrival Date</strong>
                {{ $FormatDateHelper::formatDate($stay->arrival_date, "m/d/y", "jS F o") }}
                {{-- this date format - 20nd of April 2024 --}}
            </div>

            <div class="reservation-option">
                <strong>Departure Date</strong>
                {{ $FormatDateHelper::formatDate($stay->departure_date, "m/d/y", "jS F o") }}
                {{-- this date format - 27nd of April 2024 --}}
            </div>

            <div class="reservation-option">
                <strong>Number of Nights</strong>
                {{ $booking->no_of_nights }}
            </div>

            <div class="reservation-option">
                <strong>Number of Adults</strong>
                {{ $booking->no_of_adults }}
            </div>

            <div class="reservation-option">
                <strong>Number of Children</strong>
                {{ $booking->no_of_children }}
            </div>

            @if ($booking?->no_of_pets > 0)
            <div class="reservation-option">
                <strong>Number of Pets</strong>
                {{ $booking?->no_of_pets }}
            </div>
            @endif
        </div>

        <div id="loading-spinner-booking-summary" class="flex justify-center hidden mt-10">
            <i class="w-40 h-40 fal fa-spinner-third animate-spin"></i>
        </div>

        <div class="hidden reserved-extras" id="extras-summary-container">
            <div class="title">Selected Extras</div>
            <div class="extras-summary-list" id="extras-summary">

            </div>
        </div>

        <div class="selected-extra extras-summary-template">
            <div class="text-left">
                <span class="quantity">
                </span>

                <span class="description">
                </span>
            </div>

            <div class="text-right">
                <span class="price">
                </span>
                <small class="pricing-type">
                </small>
            </div>
        </div>

        <div class="stay-price">
            Total Price:
            <strong id="total-price"></strong>
        </div>

    </div>
</div>
