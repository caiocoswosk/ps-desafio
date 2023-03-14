main()

function main() {
  let qttItensPage = 12;
  resetPage(qttItensPage);

  // scroll-menu -------------------------------------------
  let menu = selectorElement("#menu");
  let scrollLeft = selectorElement("#scroll-left");
  let scrollRight = selectorElement("#scroll-right");

  scrollLeft.addEventListener("click", () => {
    menu.scrollTo(menu.scrollLeft - menu.clientWidth / 2, 0);
  });

  scrollRight.addEventListener("click", () => {
    menu.scrollTo(menu.scrollLeft + menu.clientWidth / 2, 0);
  });

  // selection-category -------------------------------------------
  selectorElements(".btn-category").forEach((e) => {
    e.addEventListener("click", () => {
      idCategory = e.parentElement.querySelector("input").value;

      if (!e.classList.contains("category-activate")) {
        let oldActivate = selectorElement(".category-activate");
        oldActivate.classList.remove("category-activate");

        e.classList.add("category-activate");

        if (idCategory == "#") {
          document
            .querySelectorAll(".product.category-hidden")
            .forEach((product) => {
              product.classList.remove("category-hidden");
            });
        } else {
          let productsShow = selectorElements(
            `.product.category-hidden > input[value="${idCategory}"]`
          );

          productsShow.forEach((product) => {
            product.parentElement.classList.remove("category-hidden");
          });

          let productsHidden = selectorElements(
            `.product:not(.category-hidden) input:not([value="${idCategory}"])`
          );
          productsHidden.forEach((product) => {
            product.parentElement.classList.add("category-hidden");
          });
        }

        resetPage(qttItensPage);
      }
    });
  });

  // change-page ----------------------------------------------------
  selectorElement("#previous-btn").addEventListener("click", () => {
    let currentPg = selectorElement("#current-page");
    if (Number(currentPg.textContent) > 1) {
      currentPg.textContent = Number(currentPg.textContent) - 1;
      changePage(qttItensPage);
    }
  });

  selectorElement("#next-btn").addEventListener("click", () => {
    let qttProducts = Math.ceil(
      selectorElements("#products-container a:not(.category-hidden)").length
    );
    let lastPg = qttProducts / qttItensPage;
    let currentPg = selectorElement("#current-page");
    if (Number(currentPg.textContent) < lastPg) {
      currentPg.textContent = Number(currentPg.textContent) + 1;
      changePage(qttItensPage);
    }
  });

  function resetPage(qttItens = 12) {
    let productsVisible = selectorElements(".product:not(.category-hidden)");
    let pageSelector = selectorElement("#select-page");
    let noneProduct = selectorElement("#none-product");
    if (productsVisible.length == 0) {
      pageSelector.classList.add("hidden");
      noneProduct.classList.remove("hidden");
    } else {
      pageSelector.classList.remove("hidden");
      noneProduct.classList.add("hidden");
    }

    selectorElement("#current-page").textContent = 1;
    changePage(qttItens);
  }

  function changePage(qttItens = 3) {
    let products = selectorElements(
      "#products-container > a:not(.category-hidden)"
    );
    products.forEach((e) => {
      e.classList.add("page-hidden");
    });

    let currentPg = Number(selectorElement("#current-page").textContent);
    for (let i = 0; i < qttItens; i++) {
      let product = products[i + qttItens * (currentPg - 1)];
      if (product) {
        product.classList.remove("page-hidden");
      }
    }

    selectorElement("#last-page").innerHTML = `${Math.ceil(
      products.length / qttItens
    )}`;
  }

  function selectorElement(query) {
    return document.querySelector(query);
  }

  function selectorElements(query) {
    return document.querySelectorAll(query);
  }
}
