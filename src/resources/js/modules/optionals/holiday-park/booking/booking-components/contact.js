import Field from '../field'
import { query } from '../api/query'

class Contact {
    fields = []
    stage = 1

    constructor(form, bookingNo) {
        this.contactForm = form
        this.bookingNo = bookingNo
        this.createFields()
    }

    createFields() {
        this.fields.push(new Field('booking_no', this.contactForm, true, 20))
        // this.fields.push(new Field('original_lead_source_code',this.contactForm, false, 20))
        // this.fields.push(new Field('contact_no',this.contactForm, false, 20))
        // this.fields.push(new Field('salutation_code', false, 20))
        this.fields.push(new Field('first_name',this.contactForm, true, 30))
        // this.fields.push(new Field('middle_name', false, 30))
        this.fields.push(new Field('surname',this.contactForm, true, 30))
        this.fields.push(new Field('address',this.contactForm, true, 50))
        this.fields.push(new Field('address_2',this.contactForm, false, 50))
        this.fields.push(new Field('city',this.contactForm, true, 50))
        this.fields.push(new Field('county',this.contactForm, true, 30))
        this.fields.push(new Field('post_code',this.contactForm, true, 20))
        // this.fields.push(new Field('phone_no', false, 30))
        this.fields.push(new Field('mobile_phone_no', this.contactForm, true, 30))
        // this.fields.push(new Field('fax_no', false, 30))
        this.fields.push(new Field('email',this.contactForm, true, 80))
        // this.fields.push(new Field('booking_agent_code', false, 20))
        // this.fields.push(new Field('booking_agent_ref_no', false, 20))
    }

    update(currentStage) {
        if (currentStage == this.stage) {
            this.updateContactInfo()
            this.updateBookingAvailability()
            return true
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            console.log('loading contact page')
        }
    }

    async updateContactInfo() {
        const URL = this.contactForm.dataset.update_contact_route
        return await query(URL, this.bookingNo, this.fields)
    }

    async updateBookingAvailability() {
        const URL = this.contactForm.dataset.update_booking_availability_route
        return await query(URL, this.bookingNo)
    }


}

export default Contact