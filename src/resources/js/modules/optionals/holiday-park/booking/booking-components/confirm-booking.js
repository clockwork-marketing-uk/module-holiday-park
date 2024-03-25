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
            this.tagBooking()
        }
    }

    async onLoad(currentStage) {
        if (this.isCurrentStage(currentStage)) {
            this.bookingInfo = await getBooking(this.bookingNo)
        }
    }

    showBookingInfo() {
        this.confirmBooking.innerHTML = this.bookingInfo.booking.booking.booking_no
    }

    isCurrentStage(currentStage) {
        return currentStage == this.stage
    }

    async tagBooking() {
        const URL = this.confirmBooking.dataset.tag_booking_route
        return await query(URL, this.bookingNo)
    }

}

export default ConfirmBooking