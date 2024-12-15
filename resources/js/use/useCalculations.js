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

    return {
        calcDifferencePercentage,
        calcBudget,
    };
}
