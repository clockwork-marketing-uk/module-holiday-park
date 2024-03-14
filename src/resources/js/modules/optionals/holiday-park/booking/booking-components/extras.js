import Field from '../field'
import { query } from '../api/query'
import { getBooking } from '../api/getBooking'
import { getMasterBookingExtras } from '../api/getMasterBookingExtras'
import { formatMoney } from '../helpers/formatMoney'
import { updateBookingSummary } from '../helpers/updateBookingSummary'

class Extras {
    fields = []
    stage = 2
    selectedExtras = []

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
    }


    async getMasterBookingExtras() {
        return await getMasterBookingExtras()
    }

    async update(currentStage) {
        if (currentStage == this.stage) {
            console.log('updating extras info')
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            this.booking = await getBooking(this.bookingNo)
            if (this.booking.booking.extras) {
                this.availabileExtras = this.booking.booking.extras
                this.hideUnusedExtras()
            }
            else {
                this.onLoad(this.currentStage)
            }
            
        }
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
        this.fields.forEach(field => {
            const extra = this.availabileExtras.find(extra => field.name === extra.code);
            if (!extra) {
                field.htmlElement.parentElement.parentElement.remove()
            }
            else {
                const priceField = field.htmlElement.parentElement.parentElement.querySelector('.price')
                if (priceField) {
                    priceField.textContent = formatMoney(extra.unit_price)
                }
            }
        });
    }

    addEventListenersToInputs() {
        this.oneOffExtrasInputs.forEach(input => {
            input.addEventListener("change", async (event) => {
                this.updateSelectedExtras(event.target.dataset.code, event.target.value)
                await this.updateExtras()
                updateBookingSummary(this.bookingNo)
            });
        });

        this.perNightExtrasInputs.forEach(input => {
            input.addEventListener("change", async (event) => {
                const value = event.target.checked ? "1" : "0"
                this.updateSelectedExtras(event.target.dataset.code, value)
                await this.updateExtras()
                updateBookingSummary(this.bookingNo)
            });
        });
    }

    updateSelectedExtras(code, quantity) {
        const newExtra = {
            code: code,
            quantity: quantity
        }

        const existingExtraIndex = this.selectedExtras.findIndex(extra => extra.code == newExtra.code);
        if (existingExtraIndex !== -1) {
            this.selectedExtras[existingExtraIndex] = newExtra;
        }
        else {
            this.selectedExtras.push(newExtra)
        }
    }

    async updateExtras() {
        const URL = this.extrasForm.dataset.update_extras_route
        const response = await query(URL, this.bookingNo, this.selectedExtras)
        const extras = response.extrasWithPrices
        return extras
    }
}

export default Extras