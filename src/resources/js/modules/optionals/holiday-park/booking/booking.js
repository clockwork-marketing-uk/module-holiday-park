import ConfirmBooking from './booking-components/confirm-booking'
import Contact from './booking-components/contact'
import Extras from './booking-components/extras'
import Notes from './booking-components/notes'
import Payment from './booking-components/payment'
import PromotionalCode from './booking-components/promotional-code'
import { validate } from './validator'

class Booking {
    constructor(bookingInfoForm, extrasForm, confirmBooking, paymentForm, bookingNo) {
        this.contact = new Contact(bookingInfoForm, bookingNo)
        this.extras = new Extras(extrasForm, bookingNo)
        this.notes = new Notes(bookingInfoForm)
        this.payment = new Payment(paymentForm)
        this.confirmBooking = new ConfirmBooking(confirmBooking, bookingNo)

        this.stageArray = [this.contact, this.notes, this.extras, this.confirmBooking, this.payment]
    }

    async updateBookingStage(index) {
        await Promise.all(this.stageArray.map(async (stage) => {
            stage.update(index);
        }))
    }

    async updateNextBookingStage(index) {
        await Promise.all(this.stageArray.map(async (stage) => {
            stage.onLoad(index + 1);
        }))
    }

    validateFields(currentState) {
        return validate(this.stageArray, currentState)
    }
}

export default Booking