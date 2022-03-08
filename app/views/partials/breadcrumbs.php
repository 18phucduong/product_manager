<?php 
    $breadcrumbsData;
    $breadcrumbsData[] = [
        'slug' => '/home',
        'name' => 'Home'
    ];
    $breadcrumbsData[] = [
        'slug' => '/products',
        'name' => 'Product'
    ];
?>
<nav class="nav">
    <p id="breadcrumbs">
        <?php
            for( $bri = 0; $bri < count($breadcrumbsData); $bri++ ) {
                if($bri == count($breadcrumbsData) - 1) {
                    ?>
                        <a href="<?php echo $breadcrumbsData[$bri]['slug']?>"><?php echo $breadcrumbsData[$bri]['name']?></a>
                    <?php
                }else {
                    ?>
                        <a href="<?php echo $breadcrumbsData[$bri]['slug']?>"><?php echo $breadcrumbsData[$bri]['name']?></a> <span>/</span>
                    <?php
                }
            }
        ?>
    </p>
</nav>