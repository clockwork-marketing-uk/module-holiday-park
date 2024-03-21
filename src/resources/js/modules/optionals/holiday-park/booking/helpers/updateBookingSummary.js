import { getBooking } from '../api/getBooking'
import { formatMoney } from './formatMoney'


async function updateBookingSummary(bookingNumber) {

    const booking = await getBooking(bookingNumber)
    const bookingSummary = document.querySelector('#booking-summary')


    if (booking && bookingSummary) {
        updatePrice()
        updateExtras()
    }

    function updatePrice () {
        const price = bookingSummary.querySelector('#total-price')
        price.textContent = formatMoney(booking.booking.booking.total_price);
    }

    function updateExtras () {
        console.log('update booking summary extras')
        const extrasSummary = bookingSummary.querySelector('#extras-summary')
        const extrasSummaryContainer = bookingSummary.querySelector('#extras-summary-container')
        extrasSummary.innerHTML = ""
        let hasSelectedExtras = false
        if (booking.booking.extras) {
            booking.booking.extras.forEach(extra => {
                if (extra.quantity > 0) {
                    hasSelectedExtras = true
                    const extrasSummaryTemplate = bookingSummary.querySelector('.extras-summary-template').cloneNode(true)
                    const price = extrasSummaryTemplate.querySelector('.price')
                    const description = extrasSummaryTemplate.querySelector('.description')
                    const pricingType = extrasSummaryTemplate.querySelector('.pricing-type')
                    const quantity = extrasSummaryTemplate.querySelector('.quantity')
        
                    price.textContent = formatMoney(extra.price)
                    description.textContent = extra.description 
                    pricingType.textContent = extra.pricing_type
                    quantity.textContent = extra.quantity
        
                    extrasSummary.appendChild(extrasSummaryTemplate)
                }
            });
        }

        if (hasSelectedExtras) {
            extrasSummaryContainer.classList.remove('hidden')
        }
        else {
            extrasSummaryContainer.classList.add('hidden')
        }

        
    }

}

export { updateBookingSummary }