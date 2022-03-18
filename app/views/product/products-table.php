<table class="table table-blue text-left" style="width: 100%">
    <thead>
        <tr style="width: inherit">
            <th class="w-100">ID</th>
            <th>Name</th>
            <th data-field-name="image" class="w-250">Image</th>
            <th data-field-name="price">Price</th>
            <th data-field-name="sale-price">Sale Price</th>
            <th class="w-250" data-field-name="tags">Tags</th>
            <th class="w-250">Actions</th>
        </tr>
    </thead>
    <tbody class="products" data-page=1>
    <?php
        foreach($products['items'] as $product) {
            ?>
            <tr data-product-id = "<?php echo $product['id']?>">
                <td class="text-center"><?php echo $product['id'] ?></td>
                <td><?php echo $product['name']?></td>
                <td data-field-name="image" ><?php echo renderImage($product['image'])?></td>
                <td data-field-name="price"  class="text-center"><?php echo convertPrice($product['price'])?></td>
                <td data-field-name="sale-price"  class="text-center"><?php echo convertPrice($product['sale_price'])?></td>
                <td data-field-name="tags">
                    <?php
                        $tags = getRelationRowsManyToManyRelationship($product['id'], 'products', 'tags', 'product_tag');
                        if( !empty($tags) ) {
                            foreach( $tags as $index => $tag ) {
                                $tagName = $tag['name'];
                                echo "<span class = 'tag'>$tagName</span>";
                            }
                        }
                    ?>
                </td>
                <td>
                    <div class="d-flex justify-c-center">
                        <button data-product-action = "edit>" class="button button-blue">
                            <span>Edit</span>
                        </button>
                        <button data-product-action = "delete>" class="button button-red">
                            <span>Delete</span>
                        </button>
                    </div>
                </td>
            </tr>

            <?php
        }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="100">
               <?php pagination($products); ?>
            </td>
        </tr>
    </tfoot>
</table>