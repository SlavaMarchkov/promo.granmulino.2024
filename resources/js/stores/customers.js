import { defineStore } from 'pinia';

import state from '@/stores/customers/state.js';
import getters from '@/stores/customers/getters.js';
import actions from '@/stores/customers/actions.js';

export const useCustomerStore = defineStore(
    {
        id: 'customers',
        state: () => (state),
        getters,
        actions,
    });
