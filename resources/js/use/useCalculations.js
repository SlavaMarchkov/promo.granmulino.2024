export function useCalculations() {
    const calcSurplusPercent = (before, plan) => {
        const numBefore = parseInt(before);
        const numPlan = parseInt(plan);
        return numBefore === 0
            ? 0
            : ((numPlan - numBefore) / numBefore * 100).toFixed();
    };

    return {
        calcSurplusPercent,
    };
}
