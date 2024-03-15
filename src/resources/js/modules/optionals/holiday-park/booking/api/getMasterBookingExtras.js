import { query } from './query'

async function getMasterBookingExtras() {
    const url = 'holiday-park/booking/get-master-booking-extras'
    return await query(url)
}

export { getMasterBookingExtras }