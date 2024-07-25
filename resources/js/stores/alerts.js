import { defineStore } from 'pinia';

import state from '@/stores/alerts/state.js';
import getters from '@/stores/alerts/getters.js';
import actions from '@/stores/alerts/actions.js';

export const useAlertStore = defineStore(
    {
        id: 'alert',
        state: () => (state),
        getters,
        actions,
    });
