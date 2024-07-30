import { defineStore } from 'pinia';

import state from '@/stores/products/state.js';
import getters from '@/stores/products/getters.js';
import actions from '@/stores/products/actions.js';

export const useProductStore = defineStore(
    {
        id: 'products',
        state: () => (state),
        getters,
        actions,
    });
