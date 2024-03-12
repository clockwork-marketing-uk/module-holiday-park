import Field from '../field'
import { query } from '../api/query'

class Extras {
    fields = []
    stage = 2
    selectedExtras = []
    selectedExtrasWithPrices = []

    constructor(form, bookingNo) {
        this.extrasForm = form
        this.bookingNo = bookingNo

        this.oneOffExtrasSection = this.extrasForm.querySelector('#one-off-extras')
        this.perNightExtrasSection = this.extrasForm.querySelector('#per-night-extras')

        console.log(this.perNightExtrasSection)
        this.oneOffExtrasInputs = this.oneOffExtrasSection.querySelectorAll('select')
        this.perNightExtrasInputs = this.perNightExtrasSection.querySelectorAll('input')

        this.addEventListenersToInputs()
    }

    createFields() {
    }

    async update(currentStage) {
        if (currentStage == this.stage) {
            console.log('updating extras info')
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            console.log('loading extras page')
        }
    }

    addEventListenersToInputs() {
        this.oneOffExtrasInputs.forEach(input => {
            input.addEventListener("change", async (event) => {
                this.updateSelectedExtras(event)
                this.selectedExtrasWithPrices = await this.queryApi()
                this.showSelectedExtrasWithPrices()
            });
        });
    }

    updateSelectedExtras(event) {
        const newExtra = {
            code: event.target.dataset.code,
            quantity: event.target.value
        }

        const existingExtraIndex = this.selectedExtras.findIndex(extra => extra.code == newExtra.code);
        if (existingExtraIndex !== -1) {
            if (newExtra.quantity !== "0") {
                this.selectedExtras[existingExtraIndex] = newExtra;
            }
            else {
                this.selectedExtras.splice(existingExtraIndex, 1);
            }
            
        }
        else if (newExtra.quantity !== "0") {
            this.selectedExtras.push(newExtra)
        }
    }

    async queryApi() {
        const URL = this.extrasForm.dataset.update_extras_route
        return await query(URL, this.bookingNo, this.selectedExtras)
    }

    showSelectedExtrasWithPrices() {
        console.log(this.selectedExtrasWithPrices)
    }


}

export default Extras