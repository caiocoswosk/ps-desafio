let messageBtn = document.querySelector("#message-content button");

if (messageBtn) {
    messageBtn.addEventListener("click", () => {
        message.parentElement.classList.add("hidden");
    });
}
