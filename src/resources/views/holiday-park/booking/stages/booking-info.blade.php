<div id="booking-info" class="" data-update_contact_route="{{ route('holiday-park.booking.update-contact') }}"
    data-update_booking_availability_route="{{ route('holiday-park.booking.update-booking-availability') }}">
    <form>
        <div class=form-content>
            <h2 class="form-heading">Personal Information</h2>
            <p>This will be used to create your booking.</p>
        </div>

        <div class="form-fields">
            <div class="form-field-inline">
                <label for="first_name" class="label">First name</label>
                <input type="text" name="first_name" id="first_name" autocomplete="given-name">
            </div>

            <div class="form-field-inline">
                <label for="surname" class="label">Last name</label>
                <input type="text" name="surname" id="surname" autocomplete="family-name">
            </div>

            <div class="form-field-inline">
                <label for="mobile_phone_no" class="label">Phone Number</label>
                <input type="tel" name="mobile_phone_no" id="mobile_phone_no" autocomplete="given-name"
                    pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$">
            </div>

            <div class="form-field-inline">
                <label for="email" class="label">Email address</label>
                <input id="email" name="email" type="email" autocomplete="email">
            </div>

            <div class="form-field-full">
                <label for="address" class="label">Address Line 1</label>
                <input type="text" name="address" id="address" autocomplete="address-line1">
            </div>

            <div class="form-field-full">
                <label for="address_2" class="label">Address Line 2</label>
                <input type="text" name="address_2" id="address_2" autocomplete="address-line2">
            </div>

            <div class="form-field-start">
                <label for="city" class="label">City</label>
                <input type="text" name="city" id="city" autocomplete="address-level2">
            </div>

            <div class="form-field-small">
                <label for="county" class="label">County</label>
                <input type="text" name="county" id="county" autocomplete="address-level1">
            </div>

            <div class="form-field-small">
                <label for="post_code" class="label">Postcode</label>
                <input type="text" name="post_code" id="post_code" autocomplete="postal-code">
            </div>

            <div class="form-field-full">
                <label for="notes" class="label">Notes</label>
                <textarea type="text" name="notes" id="notes" autocomplete="given-name"></textarea>
            </div>
        </div>
    </form>
</div>
