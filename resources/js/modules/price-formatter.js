document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('price-input');

    if (input) {
        input.addEventListener('blur', function () {
            let value = this.value.replace(/,/g, '');
            
            if (!isNaN(value) && value !== "") {
                this.value = Number(value).toLocaleString();
            }
        });

        input.addEventListener('focus', function () {
            this.value = this.value.replace(/,/g, '');
        });
    }
});