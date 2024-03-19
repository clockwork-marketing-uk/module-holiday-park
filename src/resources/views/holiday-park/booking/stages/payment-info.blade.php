<div id="payment-info" class="hidden">
    <form method="POST" action="{{ route('holiday-park.booking.begin-payment') }}" id="payment-form">
        @csrf
        
        <div class=form-content>
            <h2 class="form-heading">Payment Info</h2>
            <p>This will be used to create your booking.</p>
        </div>

        <div class=form-content>
            <h2 class="form-heading">Billing Address</h2>
            {{-- <p>This will be used to create your booking.</p> --}}
        </div>

        <div class="form-fields">
            <div class="sm:col-span-3">
                <label for="address1" class="label">Address Line 1</label>
                <input type="text" name="address1" id="address1" autocomplete="address1" value="88">
            </div>

            <div class="sm:col-span-3">
                <label for="address2" class="label">Address Line 2</label>
                <input type="text" name="address2" id="address2" autocomplete="address2">
            </div>

            <div class="sm:col-span-3">
                <label for="address3" class="label">Address Line 3</label>
                <input type="text" name="address3" id="address3" autocomplete="address3">
            </div>

            <div class="sm:col-span-3">
                <label for="city" class="label">City</label>
                <input type="text" name="city" id="city" autocomplete="city">
            </div>

            <div class="sm:col-span-3">
                <label for="postalCode" class="label">Postal Code</label>
                <input type="text" name="postalCode" id="postalCode" autocomplete="postalCode" value="412">
            </div>

            <div class="sm:col-span-3">
                <label for="country" class="label">Country</label>
                <input type="text" name="country" id="country" autocomplete="country" value="GB">
            </div>

            <div class="hidden sm:col-span-3">
                <label for="state" class="label">State</label>
                <input type="hidden" name="state" id="state" autocomplete="state">
            </div>

            <div class="hidden sm:col-span-3">
                <label for="booking_no" class="label"></label>
                <input type="hidden" name="booking_no" id="booking_no" autocomplete="booking_no" value="{{ $booking->booking_no }}">
            </div>
        </div>

        <div class=form-content>
            <h2 class="form-heading">Card Details</h2>
            {{-- <p>This will be used to create your booking.</p> --}}
        </div>

        <div class="form-fields">
            <div class="sm:col-span-3">
                <label for="cardholderName" class="label">Card Holder Name</label>
                <input type="text" name="cardholderName" id="cardholderName" autocomplete="cardholderName" value="Squidward Tentacles">
            </div>

            <div class="sm:col-span-3">
                <label for="cardNumber" class="label">Card Number</label>
                <input type="text" name="cardNumber" id="cardNumber" autocomplete="cardNumber" value="4929000000006">
            </div>

            <div class="sm:col-span-3">
                <label for="expiryDate" class="label">Expiry Date</label>
                <input type="text" name="expiryDate" id="expiryDate" autocomplete="expiryDate" value="0223">
            </div>

            <div class="sm:col-span-3">
                <label for="securityCode" class="label">Security Code</label>
                <input type="text" name="securityCode" id="securityCode" autocomplete="securityCode" value="123">
            </div>
        </div>

        <div class=form-content>
            <h2 class="form-heading">Your Details</h2>
            {{-- <p>This will be used to create your booking.</p> --}}
        </div>

        <div class="form-fields">
            <div class="sm:col-span-3">
                <label for="customerFirstName" class="label">First Name</label>
                <input type="text" name="customerFirstName" id="customerFirstName" autocomplete="customerFirstName">
            </div>

            <div class="sm:col-span-3">
                <label for="customerLastName" class="label">Last Name</label>
                <input type="text" name="customerLastName" id="customerLastName" autocomplete="customerLastName">
            </div>

            <div class="sm:col-span-3">
                <label for="customerEmail" class="label">Email</label>
                <input type="text" name="customerEmail" id="customerEmail" autocomplete="customerEmail">
            </div>

            <div class="sm:col-span-3">
                <label for="customerPhone" class="label">Phone</label>
                <input type="text" name="customerPhone" id="customerPhone" autocomplete="customerPhone">
            </div>
        </div>
    </form>

    <button class="bg-blue-500 btn secondary-btn" type="submit" form="payment-form" value="Submit">Pay & Confirm Booking</button>

</div>