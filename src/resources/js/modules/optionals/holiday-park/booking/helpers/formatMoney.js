function formatMoney(number) {
    number = number.replace(/,/g,"");
    number = parseInt(number)
    return number.toLocaleString('en-GB', { style: 'currency', currency: 'GBP' });
}

export { formatMoney }