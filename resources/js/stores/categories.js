import { defineStore } from 'pinia';

import state from '@/stores/categories/state.js';
import getters from '@/stores/categories/getters.js';
import actions from '@/stores/categories/actions.js';

export const useCategoryStore = defineStore(
    {
        id: 'categories',
        state: () => (state),
        getters,
        actions,
    });
