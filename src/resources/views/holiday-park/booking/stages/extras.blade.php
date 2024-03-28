<div id="extras-page" class="hidden" data-update_extras_route="{{ route('holiday-park.booking.update-extras') }}">

    <div class=section-title>
        <h2 class="title">Availabile Extras</h2>
        {{-- <p>Would you like to add any of the following options.</p> --}}
        <p>There are a variety of extras available with your stay. These vary based on the accommodation booked.</p>
        <p>Please contact us to find out what extras are available for your stay and we will add them to your booking.</p>
        <p>This includes extras such as ...</p>
        <p class="mt-2">
            <ul class="list-disc">
                <li>Awnings</li>
                <li>Cots</li>
                <li>High Chairs</li>
                <li>Gazebos</li>
                <li>Prosecco</li>
                <li>Welcome Pack</li>
            </ul>
        </p>
        <p class="mt-2">Call us on <a href="tel:+441803770206">01803 770206</a> or email us at <a href="mailto:info@leonardscove.co.uk">info@leonardscove.co.uk</a>.</p>
    </div>

    <div id="loading-spinner-extras-container">
        <div id="loading-spinner-extras" class="hidden">
            <i class="spin-icon fal fa-spinner-third animate-spin"></i>
        </div>
    </div>

    {{-- <div id="extras-wrap" class="extras-wrap">
        <div class="extra-option" id="one-off-extras">
            <div class="title">One off Extras</div>

            @foreach ($extras['oneOffs'] as $index => $extra)
                <div class="option" data-code="{{ $extra->code }}">

                    <div class="option-name">
                        <strong>{{ $extra->name }} (max.{{ $extra->maximum_quantity }})</strong>
                    </div>

                    <div class="option-selector">
                        <span class="price"></span>

                        <select class="hidden" data-name="{{ $extra->name }}" data-code="{{ $extra->code }}"
                            name="{{ $extra->code }}" id="" value="{{ $extra->default_quantity }}">
                            @for ($i = $extra->minimum_quantity; $i <= $extra->maximum_quantity; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="extra-option" id="per-night-extras">
            <div class="title">Per Night Extras</div>

            @foreach ($extras['perNights'] as $index => $extra)
                <div class="option" data-code="{{ $extra->code }}">

                    <div class="option-name">
                        <strong>{{ $extra->name }}</strong>
                    </div>

                    <div class="option-selector">
                        <span class="price"></span>

                        <input type="checkbox" id="" data-name="{{ $extra->name }}"
                            data-code="{{ $extra->code }}" name="{{ $extra->code }}"
                            value="{{ $extra->default_quantity }}" />
                    </div>

                </div>
            @endforeach
        </div>
    </div> --}}
</div>
