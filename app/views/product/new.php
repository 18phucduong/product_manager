
<?php
    if( isset($product) ) { 
        $product =  unserialize (serialize ($product));
    }
    if( isset($tags) ) {    
        $tags =  unserialize (serialize ($tags));
    }
    if( isset($product_tags) ) { 
        $product_tags =  unserialize (serialize ($product_tags));
    }
?>
<div id="main-content" class="container-fluid"> 
<form action="<?php echo route('product.store');?>" method="post" enctype="multipart/form-data">     
    <div class="row">   
        <div class=" col">
            <h3>Title</h3>
            <div class="input-group">
                <input type="text" name="name" class="input-title" id="name" value ="<?php echo isset($product->data['name']) ? $product->data['name'] : '' ?>">
                <?php if(isset($product->messages['name'])) {viewValidateMessage($product->messages['name']);}?>
            </div>
            <div class="mb-2">
                <span>Link: /product/ <input type="text" name="slug" value="<?php echo isset($product->data['slug']) ? $product->data['slug'] : ''?>"></span>
                <?php if(isset($product->messages['slug'])) {viewValidateMessage($product->messages['slug']);}?>
            </div>
            <h3>Description</h3>
            <div class="input-group">
                <textarea name="description" id="description" cols="30" rows="10"><?php echo isset($product->data['description']) ? $product->data['description'] : '' ?></textarea>
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
                            <input type="text" name="price" id="price" value="<?php echo isset($product->data['price']) ? $product->data['price'] : '' ?>">
                            <?php if(isset($product->messages['price'])) {viewValidateMessage($product->messages['price']);}?>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Sale price:</span>
                            <input type="text" name="sale_price" id="price" value="<?php echo isset($product->data['sale_price']) ? $product->data['sale_price'] : '' ?>">
                            <?php if(isset($product->messages['sale_price'])) {viewValidateMessage($product->messages['sale_price']);}?>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Tags</span>
                            <div class="terms-box">
                            <?php
                                foreach($tags as  $tag) {
                                    ?>
                                        <div class="checkbox-group">
                                            <input 
                                                type="checkbox" 
                                                id="tag-<?php echo $tag['id']?>" 
                                                name="product_tags[]" 
                                                value="<?php echo $tag['id']?>"
                                                <?php if(isset( $product_tags->data) && !empty($product_tags->data)){ echo isChecked($tag['id'], $product_tags->data) ? 'checked' : ''; }?>
                                            >
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
                            <input type="text" name="image" id="image" style="display:none">
                            <img id="preview-output" class="hide">
                            
                            <input type="file" name="image" accept="image/*" id="preview-input">
                            <?php if(isset($product->messages['image'])) {viewValidateMessage($product->messages['image']);}?>
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