import { query } from '../api/query'

class ConfirmBooking {
    stage = 3
    constructor(form, bookingNo) {
        this.confirmBooking = form
        this.bookingNo = bookingNo
    }

    update(currentStage) {
        if (this.isCurrentStage(currentStage)) {
            console.log('updating confirm booking info')
        }
    }

    async onLoad(currentStage) {
        if (this.isCurrentStage(currentStage)) {
            console.log('loading confirm booking page')
            this.bookingInfo = await this.queryApi()
        }
    }

    async queryApi() {
        const URL = this.confirmBooking.dataset.get_booking_route
        return await query(URL, this.bookingNo)
    }

    isCurrentStage(currentStage) {
        return currentStage == this.stage
    }
}

export default ConfirmBooking