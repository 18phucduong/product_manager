<div id="main-content" class="container-fluid"> 
<form action="<?php echo route('product.store');?>" method="post" enctype="multipart/form-data">     
    <div class="row">   
        <div class=" col">
            <h3>Title</h3>
            <div class="input-group">
                <input type="text" name="product_name" class="input-title" id="product_name" value ="<?php echo isset($product->name) ? $product->name : '' ?>">
                <?php if(isset($product->message['name'])) {viewValidateMessage($product->message['name']);}?>
            </div>
            <div class="mb-2">
                <span>Link: /product/ <input type="text" name="product_slug" value="<?php echo isset($product->name) ? $product->name : '' ?> "></span>
                <?php if(isset($product->message['slug'])) {viewValidateMessage($product->message['slug']);}?>
            </div>
            <h3>Description</h3>
            <div class="input-group">
                <textarea name="product_desc" id="product_desc" cols="30" rows="10"><?php echo isset($product->description) ? $product->description : '' ?></textarea>
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
                            <input type="text" name="product_price" id="product_price" value="<?php echo isset($product->price) ? $product->price : '' ?>">
                            <?php if(isset($product->message['name'])) {viewValidateMessage($product->message['price']);}?>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Sale price:</span>
                            <input type="text" name="product_sale_price" id="product_price" value="<?php echo isset($product->sale_price) ? $product->sale_price : '' ?>">
                            <?php if(isset($product->message['name'])) {viewValidateMessage($product->message['sale_price']);}?>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Tags</span>
                            <div class="terms-box">
                            <?php
                                foreach($tags as $tag) {
                                    ?>
                                        <div class="checkbox-group">
                                            <input 
                                                type="checkbox" 
                                                id="tag-<?php echo $tag['id']?>" 
                                                name="product_tags[]" 
                                                value="<?php echo $tag['id']?>"
                                                <?php if(isset($product->tags)){ echo isChecked($tag['id'], $product->tags) ? 'checked' : ''; }?>
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
                            <!-- <input type="text" name="product_image" id="product_image"> -->
                            <img id="preview-output" class="hide">
                            <?php if(isset($product->message['image'])) {viewValidateMessage($product->message['image']);}?>
                            <input type="file" name="product_image" accept="image/*" id="preview-input">
                            <?php viewValidateMessage($product->message['product_name'])?>
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