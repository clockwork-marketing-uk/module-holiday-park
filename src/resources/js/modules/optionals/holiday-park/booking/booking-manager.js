import Booking from './booking'
import { updateBookingStepper } from './booking-stepper'

class BookingManager {
    constructor() {
        this.bookingPage = document.querySelector('#holiday-park-booking-page')
        this.bookingInfo = this.bookingPage.querySelector('#booking-info')
        this.confirmBooking = this.bookingPage.querySelector('#confirm-booking')
        this.extras = this.bookingPage.querySelector('#extras-page')
        this.paymentInfo = this.bookingPage.querySelector('#payment-info')
        this.bookingSummary = this.bookingPage.querySelector('#booking-summary')
        this.nextButton = this.bookingPage.querySelector('#next-button')
        this.backButton = this.bookingPage.querySelector('#back-button')
        this.bookingStepper = this.bookingPage.querySelector('#booking-stepper')
        this.loadingSpinner = this.bookingPage.querySelector('#loading-spinner')
        this.bookingStates = [this.bookingInfo, this.extras,this.confirmBooking, this.paymentInfo]
        this.bookingStatesSize = this.bookingStates.length - 1
        this.currentState = -1
        this.bookingNo = this.bookingPage.dataset.booking_id
        this.booking = new Booking(this.bookingInfo, this.extras, this.confirmBooking, this.paymentInfo, this.bookingNo)
        this.addEventListenersToButtons()
        this.changeState(1, true)
        console.log(this.currentState)
    }

    addEventListenersToButtons() {
        this.nextButton.addEventListener("click", (event) => {
            event.stopPropagation();
            event.preventDefault();
            this.next()
        });

        this.backButton.addEventListener("click", (event) => {
            event.stopPropagation();
            event.preventDefault();
            this.back()
        });
    }

    next() {
        if (this.currentState < this.bookingStatesSize) {
            this.changeState(1)
        }
        this.scrollToTop()
    }

    back() {
        if (this.currentState > 0) {
            this.changeState(-1)
        }
        this.scrollToTop()
    }

    scrollToTop() {
        window.scrollTo({top: 0, left: 0, behavior: "smooth" });
    }

    hideAllPages() {
        this.hideElement(this.bookingInfo)
        this.hideElement(this.extras)
        this.hideElement(this.confirmBooking)
        this.hideElement(this.paymentInfo)
    }

    showElement(element) {
        element.classList.remove('hidden')
    }

    hideElement(element) {
        element.classList.add('hidden')
    }

    updateButtons() {
        this.hideElement(this.backButton)
        this.hideElement(this.nextButton)

        if (this.currentState > 0) {
            this.showElement(this.backButton)
        }
        if (this.currentState < this.bookingStatesSize) {
            this.showElement(this.nextButton)
        }
        if (this.currentState == this.bookingStatesSize - 1) {
            this.nextButton.querySelector('.button-text').innerHTML = "<strong>Confirm</strong>"
        }
        else {
            this.nextButton.querySelector('.button-text').innerHTML = "Next"
        }
    }

    checkIfPaymentPage() {
        if (this.currentState == this.bookingStatesSize) {
            this.hideElement(this.backButton)
            this.hideElement(this.bookingSummary)
        }
    }

    async goToNextStage(value) {
        this.currentState += value
        this.updateButtons()
        updateBookingStepper(this.bookingStepper, this.currentState)
        this.checkIfPaymentPage()
        this.hideAllPages()
        if (Math.sign(value) == 1) {
            this.showElement(this.loadingSpinner)
            await this.booking.updateBookingStage(this.currentState)
            await this.booking.updateNextBookingStage(this.currentState)
            this.hideElement(this.loadingSpinner)
        }
        this.showElement(this.bookingStates[this.currentState])
    }

    async changeState(value, force = false) {
        const validation = this.booking.validateFields(this.currentState + 1)
        if (validation || force) {
            await this.goToNextStage(value)
        }
        else {
            this.showErrorMessage(validation)
        }
    }

    showErrorMessage(message) {
        console.log(message)
    }
}

function isBookingPage() {
    return document.querySelector('#holiday-park-booking-page')
}

window.addEventListener("load", (event) => {
    if (isBookingPage()) {
        const bookingManager = new BookingManager()
    }
});

// export default (new BookingManager)