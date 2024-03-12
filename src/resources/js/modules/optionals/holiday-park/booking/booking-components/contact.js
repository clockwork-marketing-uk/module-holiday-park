import Field from '../field'

class Contact {
    fields = []
    stage = 1

    constructor(form) {
        this.contactForm = form
        this.createFields()
    }

    createFields() {
        this.fields.push(new Field('booking_no', this.contactForm, true, 20))
        // this.fields.push(new Field('original_lead_source_code',this.contactForm, false, 20))
        this.fields.push(new Field('contact_no',this.contactForm, false, 20))
        // this.fields.push(new Field('salutation_code', false, 20))
        this.fields.push(new Field('first_name',this.contactForm, true, 30))
        // this.fields.push(new Field('middle_name', false, 30))
        this.fields.push(new Field('surname',this.contactForm, false, 30))
        this.fields.push(new Field('address',this.contactForm, false, 50))
        this.fields.push(new Field('address_2',this.contactForm, false, 50))
        this.fields.push(new Field('city',this.contactForm, false, 50))
        this.fields.push(new Field('county',this.contactForm, false, 30))
        this.fields.push(new Field('post_code',this.contactForm, false, 20))
        // this.fields.push(new Field('phone_no', false, 30))
        // this.fields.push(new Field('mobile_phone_no', false, 30))
        // this.fields.push(new Field('fax_no', false, 30))
        this.fields.push(new Field('email',this.contactForm, false, 80))
        // this.fields.push(new Field('booking_agent_code', false, 20))
        // this.fields.push(new Field('booking_agent_ref_no', false, 20))
    }

    update(currentStage) {
        if (currentStage == this.stage) {
            console.log('updating contact info')
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            console.log('loading contact page')
        }
    }
}

export default Contact