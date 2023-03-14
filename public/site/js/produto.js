main();

function main() {
    let quantityBuyInput = document.querySelector(
        '#quantity-buy input[type="number"]'
    );

    quantityBuyInput.addEventListener("keypress", (evt) => {
        evt.preventDefault();
    });

    let quantityLessBtn = document.querySelector("#quantity-less");

    quantityLessBtn.addEventListener("click", (evt) => {
        evt.preventDefault();
        if (Number(quantityBuyInput.value) > 1)
            quantityBuyInput.value = Number(quantityBuyInput.value) - 1;
    });

    let quantityMoreBtn = document.querySelector("#quantity-more");

    quantityMoreBtn.addEventListener("click", (evt) => {
        evt.preventDefault();
        if (Number(quantityBuyInput.value) + 1 <= quantityBuyInput.max)
            quantityBuyInput.value = Number(quantityBuyInput.value) + 1;
    });
}
