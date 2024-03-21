<div id="payment-info">
    <form method="POST" action="{{ route('holiday-park.booking.begin-payment') }}" id="payment-form">
        @csrf

        <div class=form-content>
            <h2 class="form-heading">Payment Info</h2>
            <p>This will be used to create your booking.</p>
        </div>

        <div class="section-heading">
            <h4>Billing Address</h4>
        </div>

        <div class="form-fields form-section">
            <div class="sm:col-span-3">
                <label for="address1" class="label">Address Line 1</label>
                <input type="text" name="address1" id="address1" autocomplete="address-line1">
            </div>

            <div class="sm:col-span-3">
                <label for="address2" class="label">Address Line 2</label>
                <input type="text" name="address2" id="address2" autocomplete="address-line2">
            </div>

            <div class="sm:col-span-3">
                <label for="address3" class="label">Address Line 3</label>
                <input type="text" name="address3" id="address3" autocomplete="address-line3">
            </div>

            <div class="sm:col-span-3">
                <label for="city" class="label">City</label>
                <input type="text" name="city" id="city" autocomplete="address-level2">
            </div>

            <div class="sm:col-span-3">
                <label for="postalCode" class="label">Postal Code</label>
                <input type="text" name="postalCode" id="postalCode" autocomplete="postal-code">
            </div>

            <div class="hidden sm:col-span-3">
                <input type="hidden" name="country" id="country" value="GB">
            </div>

            <div class="hidden sm:col-span-3">
                <input type="hidden" name="state" id="state">
            </div>

            <div class="hidden sm:col-span-3">
                <input type="hidden" name="booking_no" id="booking_no"
                    value="{{ $booking->booking_no }}">
            </div>
        </div>

        <div class="section-heading">
            <h4>Card Details</h4>
        </div>

        <div class="form-fields form-section">
            <div class="sm:col-span-3">
                <label for="cardholderName" class="label">Card Holder Name</label>
                <input type="text" name="cardholderName" id="cardholderName" autocomplete="cc-name">
            </div>

            <div class="sm:col-span-3">
                <label for="cardNumber" class="label">Card Number</label>
                <input type="text" name="cardNumber" id="cardNumber" autocomplete="cc-number" minlength="13">
            </div>

            <div class="sm:col-span-3">
                <label for="expiryDate" class="label">Expiry Date e.g 0426</label>
                <input type="text" name="expiryDate" id="expiryDate" autocomplete="cc-exp" minlength="4">
            </div>

            <div class="sm:col-span-3">
                <label for="securityCode" class="label">Security Code</label>
                <input type="text" name="securityCode" id="securityCode" autocomplete="cc-csc" minlength="3">
            </div>
        </div>

        <div class="section-heading">
            <h4>Your Details</h4>
        </div>

        <div class="form-fields form-section">
            <div class="sm:col-span-3">
                <label for="customerFirstName" class="label">First Name</label>
                <input type="text" name="customerFirstName" id="customerFirstName"
                    autocomplete="given-name">
            </div>

            <div class="sm:col-span-3">
                <label for="customerLastName" class="label">Last Name</label>
                <input type="text" name="customerLastName" id="customerLastName" autocomplete="family-name">
            </div>

            <div class="sm:col-span-3">
                <label for="customerEmail" class="label">Email</label>
                <input type="email" name="customerEmail" id="customerEmail" autocomplete="email">
            </div>

            <div class="sm:col-span-3">
                <label for="customerPhone" class="label">Phone</label>
                <input type="text" name="customerPhone" id="customerPhone" autocomplete="tel">
            </div>
        </div>
    </form>

    @if ($errors->any())
        <div id="form-errors" class="my-6">
            @foreach ($errors->all() as $error)
                <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <div class="pay-now">
        <button id="pay-now-button" class="btn secondary-btn pay-btn" type="submit" form="payment-form" value="Submit">
            Pay & Confirm Booking</button>
    </div>

</div>
