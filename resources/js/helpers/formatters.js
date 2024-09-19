export function formatNumber(number) {
    const formatter = new Intl.NumberFormat('ru', {
        style: 'decimal',
    });
    return formatter.format(number);
}
