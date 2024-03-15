<div id="booking-summary" class="mx-auto mb-10 top-10 md:sticky">
    @imageLazy($accommodation->images[0], ['class' => 'w-96'])

    <div class="mt-2">Arrive {{ $stay->arrival_date }}</div>
    <div>Depart {{ $stay->departure_date }}</div>

    <div class="mt-4">Number of Nights {{ $stay->no_of_nights }}</div>
    <div id="total-price">Price {{ $stay->price }}</div>


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
</div>
