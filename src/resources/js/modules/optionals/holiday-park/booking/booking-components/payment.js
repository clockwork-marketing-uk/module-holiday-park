import Field from "../field"

class Payment {
  stage = 4
  fields = []

  constructor(paymentForm, contactInfo) {
    this.paymentForm = paymentForm
    this.contactInfo = contactInfo
    this.createFields()
  }

  update(currentStage) {
    if (currentStage == this.stage) {
    }
  }

  async onLoad(currentStage) {
    if (currentStage == this.stage) {
      this.updateExistingFields()
    }
  }

  createFields() {
    this.fields.push(new Field("address1", this.paymentForm, true))
    this.fields.push(new Field("address2", this.paymentForm, true))
    this.fields.push(new Field("address3", this.paymentForm, true))
    this.fields.push(new Field("city", this.paymentForm, true))
    this.fields.push(new Field("postalCode", this.paymentForm, true))
    this.fields.push(new Field("country", this.paymentForm, true))
    // this.fields.push(new Field('state',this.paymentForm, false))
    this.fields.push(new Field("cardholderName", this.paymentForm, true))
    this.fields.push(new Field("cardNumber", this.paymentForm, true))
    this.fields.push(new Field("expiryDate", this.paymentForm, true))
    this.fields.push(new Field("securityCode", this.paymentForm, true))
    this.fields.push(new Field("customerFirstName", this.paymentForm, true))
    this.fields.push(new Field("customerLastName", this.paymentForm, true))
    this.fields.push(new Field("customerEmail", this.paymentForm, true))
    this.fields.push(new Field("customerPhone", this.paymentForm, true))
  }

  updateExistingFields() {
    const address1 = this.contactInfo.fields.find((field) => field.name === "address")
    if (address1.value) {
      this.paymentForm.querySelector("#address1").value = address1.value
    }

    const address2 = this.contactInfo.fields.find((field) => field.name === "address_2")
    if (address2.value) {
      this.paymentForm.querySelector("#address2").value = address2.value
    }

    const city = this.contactInfo.fields.find((field) => field.name === "city")
    if (city.value) {
      this.paymentForm.querySelector("#city").value = city.value
    }

    const postCode = this.contactInfo.fields.find((field) => field.name === "post_code")
    if (postCode.value) {
      this.paymentForm.querySelector("#postalCode").value = postCode.value
    }

    const firstName = this.contactInfo.fields.find((field) => field.name === "first_name")
    if (firstName.value) {
      this.paymentForm.querySelector("#customerFirstName").value = firstName.value
    }

    const lastName = this.contactInfo.fields.find((field) => field.name === "surname")
    if (lastName.value) {
      this.paymentForm.querySelector("#customerLastName").value = lastName.value
    }

    const email = this.contactInfo.fields.find((field) => field.name === "email")
    if (email.value) {
      this.paymentForm.querySelector("#customerEmail").value = email.value
    }

    const phone = this.contactInfo.fields.find((field) => field.name === "mobile_phone_no")
    if (phone.value) {
      this.paymentForm.querySelector("#customerPhone").value = phone.value
    }
  }
}

export default Payment
