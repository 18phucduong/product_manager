window.addEventListener('DOMContentLoaded', (event) => {
    document.ajaxInformation = {
      rootBranchSelector : '#product-table ',
      APIUrl             :  'http://localhost/product_manager/public/api',
      pagination         :  {
        paginateItemsSelector : '.paginate .pagi-item ',
        page                  : 1
      },
      deleteButtonsSelector : 'button[data-product-action="delete"] '

    }  
    // set events
    setPaginateEvent();
    setDeleteEvent();
  
  });
  function setPaginateEvent() {
    let paginateButtonsQuery = document.ajaxInformation.pagination.paginateItemsSelector;
    let paginateButtons = document.querySelectorAll(paginateButtonsQuery);

    paginateButtons.forEach( (paginationItem) =>  {
      paginationItem.onclick = function() {
        currentPage =  document.ajaxInformation.pagination.page = paginationItem.getAttribute('data-page');
        loadView();
      };
    });
  }
  function setDeleteEvent() {
    let selector = document.ajaxInformation.deleteButtonsSelector;
    let deleteButtons = document.querySelectorAll(selector);
    deleteButtons.forEach( (button) => {
      button.onclick = function() {
        let deleteStatus = confirm("Delete product?");
        if( !deleteStatus ) { return; }
        let id = button.getAttribute('data-product-id');
        deleteProductID(id);
      }
    });
  }
  function deleteProductID(id){
    let url = document.ajaxInformation.APIUrl + '/product/delete/{id}';
    url = url.replace('{id}', id);
    loadAjax({
        method: 'DELETE',
        url: url,
        contentType: 'application/json',
        successCallback : function(response){
          console.log(response);
          if( response == 'false' ) {
              alert("Can't delete this product!");
              return 0;
          }
          alert("Delete successful!");
          loadView();

        },
        failedCallback: function(response) {
        reloadElement.innerHTML = '404';
        }
    });
}
  function loadView(){ 
    let url =  document.ajaxInformation.APIUrl + '/product/page/{page}';
    let page = document.ajaxInformation.pagination.page;
    
    let reloadElementSelector =  document.ajaxInformation.rootBranchSelector;
    let reloadElement =  document.querySelector( reloadElementSelector );

    if( page < 1 ) { return; }

    url = url.replace('{page}', page);

    loadAjax({
      method: 'GET',
      url: url,
      successCallback : function(response){
        reloadElement.innerHTML = response;
        setPaginateEvent();
        setDeleteEvent();
      },
      failedCallback: function(response) {
        reloadElement.innerHTML = '404';
      }
    });
  }
  

  function loadAjax(setting) {
    let xhr = new XMLHttpRequest();
    sendUrl = setting.url;
    method = setting.method;
    contentType = setting.hasOwnProperty('contentType') ? setting.contentType : 'application/x-www-form-urlencoded';
    data = JSON.stringify(setting.data);
  
    xhr.onreadystatechange = function(){
        if (xhr.readyState === 4) {
            // Check the response status.
            if (xhr.status === 200) {
              setting.successCallback(xhr.response);
            } else {
              setting.failedCallback(xhr.response);
            }
        }
    }
    xhr.open(method, sendUrl);
    xhr.setRequestHeader('Content-Type', contentType);
    xhr.send('data=' + data);
  }
  
