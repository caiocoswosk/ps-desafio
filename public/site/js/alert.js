alert()

function alert() {
    let alertBtn = document.querySelector("#alert-content button");
    let alert = document.querySelector("#alert-content");

    if (alertBtn) {
        alertBtn.addEventListener("click", () => {
            alert.classList.add("hidden");
        });
    }
}
