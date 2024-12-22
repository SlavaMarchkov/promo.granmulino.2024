import { convertInputStringToNumber } from '@/helpers/formatters.js';

export function useCalculations() {
    const calcDifferencePercentage = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        const difference = numB - numA;
        return numA === 0 ? 0 : Math.round((difference / numA) * 100);
    };

    const calcBudget = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA);
        const numB = convertInputStringToNumber(valueB);
        return parseInt((numA * numB).toFixed(0));
    };

    const calcSalesSurplus = (valueA, valueB) => {
        const numA = convertInputStringToNumber(valueA.toString());
        const numB = convertInputStringToNumber(valueB.toString());
        return parseInt((numA + (numA * numB) / 100).toFixed(2));
    };

    return {
        calcDifferencePercentage,
        calcBudget,
        calcSalesSurplus,
    };
}
