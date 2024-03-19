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

        <div class="reservation-option">
            <strong>Arrival Date</strong>
            {{ $stay->arrival_date }}
            {{-- this date format - 20nd of April 2024 --}}
        </div>

        <div class="reservation-option">
            <strong>Departure Date</strong>
            {{ $stay->departure_date }}
            {{-- this date format - 27nd of April 2024 --}}
        </div>

        <div class="reservation-option">
            <strong>Number of Nights</strong>
            {{ $booking->no_of_nights }}
        </div>

        <div class="reservation-option">
            <strong>Number of Guests</strong>
            {{ $booking->no_of_adults }}
        </div>

        <div class="reservation-option">
            <strong>Number of Pets</strong>
            {{ $booking->no_of_pets }}
        </div>

        <div id="extras-summary">

        </div>
    
        <div class="flex flex-row extras-summary-template gap-x-4">
            <div class="quantity">
            </div>
            <div class="description">
            </div>
            <div class="price">
            </div>
            <div class="pricing-type">
            </div>
        </div>

        <div class="reservation-option price">
            Price
            <strong id="total-price"></strong>
        </div>

    </div>
</div>
