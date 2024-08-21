import { getActivePinia } from 'pinia';

export const resetAllPiniaStores = () => {
    const pinia = getActivePinia();

    if ( !pinia ) {
        throw new Error('There is no active Pinia instance');
    }

    const activeStores = Object.keys(pinia.state.value);
    activeStores.forEach((store) => {
        pinia._s.get(store).$reset();
    });
};
