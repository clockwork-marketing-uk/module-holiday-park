<div id="booking-summary" class="mx-auto mb-10 top-10 md:sticky">
    @imageLazy($accommodation->images[0], ['class' => 'w-96'])

    <div class="mt-2">Arrive {{ $stay->arrival_date }}</div>
    <div>Depart {{ $stay->departure_date }}</div>

    <div class="mt-4">Number of Nights {{ $stay->no_of_nights }}</div>
    <div>Price {{ $stay->price }}</div>

</div>
