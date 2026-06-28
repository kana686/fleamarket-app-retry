document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('payment-method-select');
    const display = document.getElementById('payment-method-display');

    if (select && display) {
        select.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            display.textContent = (this.value === "") ? '未選択' : selectedText;
        });
    }
});