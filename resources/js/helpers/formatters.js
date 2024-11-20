export function formatNumber(number) {
    const formatter = new Intl.NumberFormat('ru', {
        style: 'decimal',
    });
    return formatter.format(number);
}

export function formatNumberWithFractions(number) {
    const formatter = new Intl.NumberFormat('ru', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
    return formatter.format(number);
}

export function formatDateToISO(date) {
    return new Date(date.getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split('T')[0];
}

export function convertInputStringToNumber(str) {
    let formattedStr = str.replace(/,/g, '.');
    formattedStr = formattedStr.replace(/[^0-9.]+/g, '');
    return parseFloat(formattedStr);
}
