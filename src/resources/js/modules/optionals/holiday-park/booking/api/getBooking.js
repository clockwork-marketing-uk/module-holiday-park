import { query } from './query'
import { updateBookingSummary } from '../helpers/updateBookingSummary'

async function getBooking(bookingNumber) {
    const url = 'holiday-park/booking/get-booking'
    return await query(url, bookingNumber)
}

export { getBooking }