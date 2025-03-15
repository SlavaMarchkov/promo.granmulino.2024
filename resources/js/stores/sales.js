import { defineStore } from 'pinia';

import state from '@/stores/sales/state.js';
import getters from '@/stores/sales/getters.js';
import actions from '@/stores/sales/actions.js';

export const useSalesStore = defineStore(
    {
        id: 'sales',
        state: () => (state),
        getters,
        actions,
    });
