import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

const $toast = useToast({
    position: 'top-right',
});

export function useHttpService() {
    const spinnerStore = useSpinnerStore();
    const alertStore = useAlertStore();

    const all = (url, config = {}) => {
        spinnerStore.showContentSpinner();
        return http.get(url, config)
            .then((response) => {
                $toast.success(response?.data.message);
                return response?.data;
            })
            .catch((error) => {
                alertStore.error(error);
                return false;
            })
            .finally(() => {
                spinnerStore.hideContentSpinner();
            });
    };

    /*function post(
        url: string,
        data = {},
        config = {},
        snackBarText = ''
    ): Promise<AxiosResponse | void | any> {
        spinnerStore.showSpinner() // Optional (if we have a centralized loader to show)
        return http
            .post(url, data, config)
            .then((response) => {
                if (snackBarText) { // Optional, if we want to show SnackBar for some success responses (eg data update))
                    snackBarStore.showSnackBar(snackBarText)
                }
                return response?.data
            })
            .catch((error: AxiosError) => {
                errorModalStore.showErrorModal(errorModalStore.title, error.message)
                return false
            })
            .finally(() => {
                spinnerStore.hideSpinner() // Optional
            })
    }*/

    return {
        all,
    };
}
