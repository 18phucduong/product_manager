<?php
    $tags = $data['tags'];
    if( isset($data['product']) ) { 
        $product = $data['product'];
        $productTags = $data['product']->tags;
    }
?>
<div id="main-content" class="container-fluid"> 
<form action="<?php echo getConfig('base_path')?>/product/new" method="post" enctype="multipart/form-data">     
    <div class="row">   
        <div class=" col">
            <h3>Title</h3>
            <div class="input-group">
                <input type="text" name="product_name" class="input-title" #id="name">
                <label for="product_name"></label>
            </div>
            <div class="mb-2">
                <span>Link: /product/ <input type="text" name="product_slug"></span>
            </div>
            <h3>Description</h3>
            <div class="input-group">
                <label for="product_desc"></label>
                <textarea name="product_desc" id="product_desc" cols="30" rows="10"></textarea>
            </div>
            <div class="input-group">
                <input type="submit" name="createProductForm" class="button button-blue" value="New">
            </div>
        </div>
        <div class="col f-grow-0 max-w-300">
            <div class="left-sidebar">
                <div class="card mb-2">
                    <div class="card-head">
                        <p class="card-title">Product</p>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-label">Price:</span>
                            <input type="text" name="product_price" id="product_price">
                        </div>
                        <div class="input-group">
                            <span class="input-label">Sale price:</span>
                            <input type="text" name="product_sale_price" id="product_price">
                        </div>
                        <div class="input-group">
                            <span class="input-label">Tags</span>
                            <div class="terms-box">
                            <?php
                                foreach($tags as $tag) {
                                    ?>
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="tag-<?php echo $tag['id']?>" name="product_tags[]" value="<?php echo $tag['id']?>">
                                            <label for="tag-<?php echo $tag['id']?>"><?php echo $tag['name']?></label>
                                        </div>     
                                    <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-head">
                        <p class="card-title">Product Image</p>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-label">IMG</span>
                            <input type="file" name="product_image" id="">
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
        
    </div>
</form>
</div>