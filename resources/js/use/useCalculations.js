import { convertInputStringToNumber, isNumberNegative } from '@/helpers/formatters.js';
import { NET_PROFIT_THRESHOLD } from '@/helpers/constants.js';

export function useCalculations() {
    const calcPercentage = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        return numA === 0 ? 0 : parseFloat(((numB / numA) * 100).toFixed(2));
    };

    const calcDifference = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        return valueB - valueA;
    };

    const calcDifferencePercentage = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        const difference = numB - numA;
        return numA === 0 ? 0 : Math.round((difference / numA) * 100);
    };

    const calcBudget = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        return parseInt((numA * numB).toFixed(2));
    };

    const calcSalesSurplus = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        return parseInt((numA + (numA * numB) / 100).toFixed(2));
    };

    const calcDiffClass = (value) => {
        return isNumberNegative(value) ? 'bg-sales-success text-success' : value === 0 ? 'bg-secondary-subtle text-black' : 'bg-sales-fail text-danger';
    };

    const calcDiffClassInverse = (value) => {
        return isNumberNegative(value) ? 'bg-sales-fail text-danger' : value === 0 ? 'bg-secondary-subtle text-black' : 'bg-sales-success text-success';
    };

    const calcDiffPercentColor = (value) => {
        return isNumberNegative(value) ? 'text-success' : value === 0 ? 'text-secondary' : 'text-danger';
    };

    const calcDiffPercentColorInverse = (value) => {
        return isNumberNegative(value) ? 'text-danger' : value === 0 ? 'text-secondary' : 'text-success';
    };

    const netProfitClass = (value) => {
        return value >= NET_PROFIT_THRESHOLD
            ? 'bg-success-light text-success'
            : 'bg-danger-light text-danger';
    };

    const promoMarkClass = (value) => {
        return value > 0 && value <= 3
            ? 'bg-danger'
            : value > 3 && value <= 5
                ? 'bg-success' : 'bg-secondary';
    };

    return {
        calcPercentage,
        calcDifferencePercentage,
        calcBudget,
        calcSalesSurplus,
        calcDifference,
        calcDiffClass,
        calcDiffClassInverse,
        calcDiffPercentColor,
        calcDiffPercentColorInverse,
        netProfitClass,
        promoMarkClass,
    };
}
