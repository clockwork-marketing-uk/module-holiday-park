import { query } from '../api/query'
import { getBooking } from '../api/getBooking'

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
            this.bookingInfo = await getBooking(this.bookingNo)
            this.showBookingInfo()
        }
    }

    showBookingInfo() {
        this.confirmBooking.innerHTML = this.bookingInfo.booking.booking.booking_no
    }

    isCurrentStage(currentStage) {
        return currentStage == this.stage
    }
}

export default ConfirmBooking