async function query(url, bookingNumber, data = null) {

    const payload = {
        booking_no: bookingNumber,
        data: data
    }

    const extraWithPrice = await axios.post(url, payload).then(
        response => {
        return response.data ?? null
        },
        error => {},
    )
    return extraWithPrice
}

export { query }