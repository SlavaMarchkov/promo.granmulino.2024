export function formatNumber(number) {
    const formatter = new Intl.NumberFormat('ru', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
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

export function convertInputStringToNumber(value) {
    let formattedStr = value.toString();
    formattedStr = formattedStr.replace(/,/g, '.');
    formattedStr = formattedStr.replace(/[^0-9.]+/g, '');
    return parseFloat(formattedStr);
}

export function isNumberNegative(num) {
    return num.toString().startsWith('-');
}

export function processInputValue(value, el) {
    const inputEl = document.getElementById(el);
    const inputValue = convertInputStringToNumber(value);
    inputEl.value = formatNumber(inputValue);
}

export function formatAsItems(number) {
    return formatNumber(number) + "&nbsp;шт.";
}

export function formatAsPercent(value) {
    return formatNumber(value) + "&#8239;%";
}

export function formatAsRUB(price) {
    return formatNumber(price) + "&nbsp;&#8381;";
}

export function formatAsRUBWithDecimals(price) {
    return formatNumberWithFractions(price) + "&nbsp;&#8381;";
}

export function formatAsPercentWithDecimals(value) {
    return formatNumberWithFractions(value) + "&#8239;%";
}
