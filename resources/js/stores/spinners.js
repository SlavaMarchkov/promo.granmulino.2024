import { defineStore } from 'pinia';

// import state from '@/stores/alerts/state.js';
// import getters from '@/stores/alerts/getters.js';
// import actions from '@/stores/alerts/actions.js';

export const useSpinnerStore = defineStore(
    {
        id: 'spinner',
        state: () => (
            {
                isCardLoading: false,
                isContentLoading: false,
                isButtonDisabled: false,
            }
        ),
        getters: {},
        actions: {
            showContentSpinner() {
                this.isContentLoading = true;
            },
            hideContentSpinner() {
                this.isContentLoading = false;
            },
        },
    });
