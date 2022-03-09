<div class="admin-content__wrap">
    <?php 
        require $appRootDir."/views/partials/content-header.php";
        if(empty($dataView)) { return view($path); }
        return view($path, $dataView);
    ?>
</div>