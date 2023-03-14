let themeIcon = document.querySelector("#theme-icon");
toggleTheme(themeIcon.innerText);

// caso o botão de troca de tema seja clicado
// o tema é trocado
toggleThemeButton = document.querySelector("#theme-button");
toggleThemeButton.addEventListener("click", () => {
    const url = document.querySelector("#toggle-theme-url").value;

    fetch(url);

    themeIcon.innerText =
        themeIcon.innerText == "dark_mode" ? "light_mode" : "dark_mode";
    toggleTheme(themeIcon.innerText, true);
});

// função de alternar o tema
function toggleTheme(theme, transition = false) {
    let colorsName = [
        ["color1", "color1-dark"],
        ["color1bg", "color1bg-dark"],
        ["color2", "color2-dark"],
        ["color3", "color3-dark"],
        ["color3bg", "color3bg-dark"],
        ["color4", "color4-dark"],
        ["color5", "color5-dark"],
        ["color6", "color6-dark"],
    ];
    let sequence = theme == "dark_mode" ? [1, 0] : [0, 1];

    let colorElements;
    // alterna a classe de color em todos os elementos
    colorsName.forEach((colorName) => {
        colorElements = document.querySelectorAll(`.${colorName[sequence[0]]}`);

        colorElements.forEach((element) => {
            // adiciona a classe de transition
            if (transition) {
                element.classList.add("transition");
            }
            element.classList.remove(`${colorName[sequence[0]]}`);
            element.classList.add(`${colorName[sequence[1]]}`);
        });
    });

    // remove a classe de transition de todos os elementos
    if (transition) {
        let transistionTimer;
        clearTimeout(transistionTimer);
        transistionTimer = setTimeout(() => {
            document.querySelectorAll(".transition").forEach((element) => {
                element.classList.remove("transition");
            });
        }, 500);
    }
}
