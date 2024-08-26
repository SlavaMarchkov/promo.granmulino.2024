export default {
    showSpinner() {
        this.isLoading = true;
    },
    hideSpinner() {
        this.isLoading = false;
    },
    disableButton() {
        this.isButtonDisabled = true;
    },
    enableButton() {
        this.isButtonDisabled = false;
    },
};
