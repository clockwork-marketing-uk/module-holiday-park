

<div id="booking-info" class="hidden w-2/3 mx-auto sm:mx-none" data-update_contact_route="{{ route('holiday-park.booking.update-contact') }}">
    <form>
        <div class="mx-auto space-y-12">
            <div class="pb-6">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">This will be used to create your booking.</p>

                <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First
                            name</label>
                        <div class="mt-2">
                            <input type="text" name="first_name" id="first_name" autocomplete="given-name"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="surname" class="block text-sm font-medium leading-6 text-gray-900">Last
                            name</label>
                        <div class="mt-2">
                            <input type="text" name="surname" id="surname" autocomplete="family-name"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="mobile_phone_no" class="block text-sm font-medium leading-6 text-gray-900">Phone Number
                        </label>
                        <div class="mt-2">
                            <input type="tel" name="mobile_phone_no" id="mobile_phone_no" autocomplete="given-name"
                                pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                            address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address Line 1
                        </label>
                        <div class="mt-2">
                            <input type="text" name="address" id="address" autocomplete="address"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="address_2" class="block text-sm font-medium leading-6 text-gray-900">Address Line 2
                        </label>
                        <div class="mt-2">
                            <input type="text" name="address_2" id="address_2" autocomplete="address_2"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2 sm:col-start-1">
                        <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                        <div class="mt-2">
                            <input type="text" name="city" id="city" autocomplete="address-level2"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="county" class="block text-sm font-medium leading-6 text-gray-900">County
                        </label>
                        <div class="mt-2">
                            <input type="text" name="county" id="county" autocomplete="address-level1"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="post_code" class="block text-sm font-medium leading-6 text-gray-900">Postcode
                        </label>
                        <div class="mt-2">
                            <input type="text" name="post_code" id="post_code" autocomplete="post_code"
                                class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="notes" class="block text-sm font-medium leading-6 text-gray-900">Notes
                        </label>
                        <div class="mt-2">
                            <textarea type="text" name="notes" id="notes" autocomplete="given-name" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>



{{-- this.fields.push(new Field('booking_no', true, 20))
this.fields.push(new Field('original_lead_source_code', false, 20))
this.fields.push(new Field('contact_no', false, 20))
this.fields.push(new Field('salutation_code', false, 20))
this.fields.push(new Field('first_name', false, 30))
this.fields.push(new Field('middle_name', false, 30))
this.fields.push(new Field('surname', false, 30))
this.fields.push(new Field('address', false, 50))
this.fields.push(new Field('address_2', false, 50))
this.fields.push(new Field('city', false, 50))
this.fields.push(new Field('county', false, 30))
this.fields.push(new Field('post_code', false, 20))
this.fields.push(new Field('phone_no', false, 30))
this.fields.push(new Field('mobile_phone_no', false, 30))
this.fields.push(new Field('fax_no', false, 30))
this.fields.push(new Field('email', false, 80))
this.fields.push(new Field('booking_agent_code', false, 20))
this.fields.push(new Field('booking_agent_ref_no', false, 20)) --}}
