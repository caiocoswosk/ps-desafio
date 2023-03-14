document.querySelectorAll('.product-price').forEach(e => {
  let price = Number(e.innerHTML)
  price = price.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
  e.innerHTML = price
});