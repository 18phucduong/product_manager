
window.addEventListener('DOMContentLoaded', (event) => {
    // Paginate
  document.productListClass ='product-table';
  setPaginateEvent('product-table');

});
function setPaginateEvent() {
  reloadElement = document.getElementById(document.productListClass);
  let paginateButtons = document.querySelectorAll('.paginate .pagi-item');
  paginateButtons.forEach( (paginationItem, key) =>  {
    paginationItem.onclick = function() {
      currentPage = paginationItem.getAttribute('data-page');
      paginate(currentPage, reloadElement);
    };
  });
}
function paginate(page, reloadElement){
  
  if( page < 1 ) { return; }
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
      if (xhr.readyState === 4) {
          // Check the response status.
          if (xhr.status === 200) {
            reloadElement.innerHTML = xhr.responseText;
            setPaginateEvent(page, xhr.reloadElement);
          } else {
            reloadElement.innerHTML = "Unexpected result: "+xhr.status;
          }
      }
  }
  xhr.open('POST', 'http://localhost/product_manager/public/api/product/paginate');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('page=' + encodeURIComponent(page));
}
