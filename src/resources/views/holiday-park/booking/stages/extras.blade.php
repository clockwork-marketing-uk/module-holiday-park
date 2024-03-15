<div id="extras-page" class="hidden mr-24" data-update_extras_route="{{ route('holiday-park.booking.update-extras') }}">
    <h1 class="mb-5 text-xl font-bold">Availabile Extras</h1>

    <div class="mb-2" id="one-off-extras">
        <h2 class="text-lg font-semibold">One off Extras</h2>
        @foreach ($extras['oneOffs'] as $index => $extra)
            <div class="flex flex-row items-center justify-between my-2 border-b one-off-extra" data-code="{{ $extra->code }}">
                <div>
                    <span class="">{{ $extra->name }}</span> <span>(max. {{ $extra->maximum_quantity }})</span> 
                </div>
                <div><span class="price"></span></div>
                <div>
                    <select class="p-2 ml-4 border" data-name="{{ $extra->name }}" data-code="{{ $extra->code }}" name="{{ $extra->code }}" id="" value="{{ $extra->default_quantity }}">
                        @for ($i = $extra->minimum_quantity; $i <= $extra->maximum_quantity; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        @endforeach
    </div>


    <div class="" id="per-night-extras">
        <h2 class="text-lg font-semibold">Per Night Extras</h2>
        @foreach ($extras['perNights'] as $index => $extra)
            <div class="flex flex-row items-center justify-between my-2 border-b per-night-extra" data-code="{{ $extra->code }}">
                <div>
                    {{ $extra->name }} 
                </div>
                <div><span class="price"></span></div>
                <div>
                    <input class="w-5 h-5 ml-4 border" type="checkbox" id="" data-name="{{ $extra->name }}" data-code="{{ $extra->code }}" name="{{ $extra->code }}" value="{{ $extra->default_quantity }}" />
                </div>
            </div>
        @endforeach
    </div>

</div>
