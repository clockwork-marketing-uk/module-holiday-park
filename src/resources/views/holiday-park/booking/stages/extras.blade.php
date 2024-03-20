<div id="extras-page" data-update_extras_route="{{ route('holiday-park.booking.update-extras') }}">

    <div class=section-title>
        <h2 class="title">Availabile Extras</h2>
        <p>Would you like to add any of the following options.</p>
    </div>

    <div class="extras-wrap">
        <div class="extra-option" id="one-off-extras">
            <div class="title">One off Extras</div>

            @foreach ($extras['oneOffs'] as $index => $extra)
                <div class="option" data-code="{{ $extra->code }}">

                    <div class="option-name">
                        <strong>{{ $extra->name }} (max.{{ $extra->maximum_quantity }})</strong>
                    </div>

                    <div class="option-selector">
                        <span class="price">£100</span>

                        <select data-name="{{ $extra->name }}" data-code="{{ $extra->code }}"
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
    </div>



</div>
