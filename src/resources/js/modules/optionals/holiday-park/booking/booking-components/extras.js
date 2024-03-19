import Field from '../field'
import { query } from '../api/query'
import { getBooking } from '../api/getBooking'
import { getMasterBookingExtras } from '../api/getMasterBookingExtras'
import { formatMoney } from '../helpers/formatMoney'
import { updateBookingSummary } from '../helpers/updateBookingSummary'
import { showLoadingSpinner, hideLoadingSpinner } from '../helpers/loadingSpinner'

class Extras {
    fields = []
    stage = 2

    constructor(form, bookingNo, bookingSummary) {
        this.extrasForm = form
        this.bookingNo = bookingNo
        this.masterExtras = this.getMasterBookingExtras()

        this.oneOffExtrasSection = this.extrasForm.querySelector('#one-off-extras')
        this.perNightExtrasSection = this.extrasForm.querySelector('#per-night-extras')

        this.oneOffExtrasInputs = this.oneOffExtrasSection.querySelectorAll('select')
        this.perNightExtrasInputs = this.perNightExtrasSection.querySelectorAll('input')

        this.addEventListenersToInputs()
        this.createFields()
        updateBookingSummary(this.bookingNo)
    }


    async getMasterBookingExtras() {
        return await getMasterBookingExtras()
    }

    async update(currentStage) {
        if (currentStage == this.stage) {
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            this.loading()

            this.booking = await getBooking(this.bookingNo)
            if (this.booking.booking.extras) {
                this.extras = this.booking.booking.extras
                this.hideUnusedExtras()
            }
            else {
                this.onLoad(this.currentStage)
            }

            this.stopLoading()

        }
    }

    loading() {
        showLoadingSpinner()
        this.extrasForm.classList.add('hidden')
    }

    stopLoading() {
        this.extrasForm.classList.remove('hidden')
        hideLoadingSpinner()
    }

    createFields() {
        this.oneOffExtrasInputs.forEach(select => {
            this.fields.push(new Field(select.name, this.oneOffExtrasSection, false))
        });

        this.perNightExtrasInputs.forEach(input => {
            this.fields.push(new Field(input.name, this.perNightExtrasSection, false))
        });
    }

    hideUnusedExtras() {
        console.log(this.extras)
        console.log(this.fields)
        this.fields.forEach(field => {
            const extra = this.extras.find(extra => field.name === extra.code);
            if (!extra) {
                field.htmlElement.parentElement.remove()
            }
            else {
                const priceField = field.htmlElement.parentElement.querySelector('.price')
                if (priceField) {
                    priceField.textContent = formatMoney(extra.unit_price)
                }

                if (field.htmlElement.tagName == "INPUT") {
                    extra.quantity > 0 ? field.htmlElement.checked = true : false
                }
                else if (field.htmlElement.tagName == "SELECT") {
                    field.htmlElement.value = extra.quantity
                }

                // field.htmlElement.value = extra.quantity
                // extra.quantity > 0 ? field.htmlElement.checked = true : false
            }
        });
    }

    addEventListenersToInputs() {
        this.oneOffExtrasInputs.forEach(input => {
            input.addEventListener("change", async (event) => {
                this.updateSelectedExtras(event.target.dataset.code, event.target.value)
                await this.updateExtras()
                await updateBookingSummary(this.bookingNo)
            });
        });

        this.perNightExtrasInputs.forEach(input => {
            input.addEventListener("change", async (event) => {
                const value = event.target.checked ? "1" : "0"
                this.updateSelectedExtras(event.target.dataset.code, value)
                await this.updateExtras()
                await updateBookingSummary(this.bookingNo)
            });
        });
    }

    updateSelectedExtras(code, quantity) {
        const newExtra = {
            code: code,
            quantity: quantity
        }

        const existingExtraIndex = this.extras.findIndex(extra => extra.code == newExtra.code);
        if (existingExtraIndex !== -1) {
            this.extras[existingExtraIndex].quantity = newExtra.quantity;
        }

    }

    async updateExtras() {
        const URL = this.extrasForm.dataset.update_extras_route
        const response = await query(URL, this.bookingNo, this.extras)
        const extras = response.extrasWithPrices
        return extras
    }
}

export default Extras