export function formatNumber(number) {
    const formatter = new Intl.NumberFormat('ru', {
        style: 'decimal',
    });
    return formatter.format(number);
}

export function formatDateToISO(date) {
    return new Date(date.getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split('T')[0];
}
