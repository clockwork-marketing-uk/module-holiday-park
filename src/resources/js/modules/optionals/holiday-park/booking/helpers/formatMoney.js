function formatMoney(number) {
    number = parseInt(number)
    return number.toLocaleString('en-GB', { style: 'currency', currency: 'GBP' });
}

export { formatMoney }