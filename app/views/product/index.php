<div id="main-content" class="container-fluid"> 
    <div class="table-control mb-2">
        <div class="row">
            <div class="col  f-grow-0">
                <div class="sorting">
                    <span>Sort by: </span>
                    <select name="sortBy" id="">
                        <option value="name">ID</option>
                        <option value="name">Name</option>
                        <option value="name">Slug</option>
                        <option value="name">Price</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="filter">
                    <div class="row row-min justify-c-end">
                        <div class = "col">
                            <span>Tags</span>
                            <select name="" id="">
                                <option value="1">Tag1</option>
                                <option value="1">Tag2</option>
                                <option value="1">Tag3</option>
                                <option value="1">Tag4</option>
                            </select>
                        </div>
                        <div class="col">
                            
                            <div class="row row-min">
                                <div class="col">
                                    <span>Price: From</span>
                                    <input type="text">
                                </div>
                                <div class="col">
                                    <span> To</span>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col f-grow-0">
                <div class="search">
                    <input type="text" name="" id="" placeholder="Search products"/>
                    <button type="button" class="button button-blue">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div  id="product-table" >
        
    <?php view('product/products-table',['products' => $products])?>
    </div>
    

</div>
