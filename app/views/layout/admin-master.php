<?php  
    session_start();
    if (isset($_SESSION['dataPage']) && !empty($_SESSION['dataPage']) ) {
        $page = $_SESSION['dataPage']['page'];
        $dataView = $_SESSION['dataPage']['dataView'];
        unset($_SESSION['dataPage']);

    
    }
    
    $viewRoot = getConfigs('app_root_dir').'/views';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo getUrlFromBasePath('/assets/css/library.css')?>">
    <link rel="stylesheet" href="<?php echo getUrlFromBasePath('/assets/css/admin.css')?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script  src="<?php echo getUrlFromBasePath('/assets/js/product.js')?>" type="text/javascript"></script>
    <title><?php echo $page['title']?></title>
</head>
<body>
    <div class="wrapper">
        <div>
            
            <div class="row row-collapse">
                <div id="admin-menu" class="col max-w-350 full-height min-h-100">
                    <?php require $viewRoot . "/blocks/main-sidebar.php"?>
                </div>
                <div id="admin-content" class="col">
                    <div class="admin-content__wrap">
                        <?php 
                            require $viewRoot . "/partials/content-header.php";
                            view($path, $dataView);
                        ?>
                    </div>             
                </div>
            </div>
        </div>
    </div>
</body>
</html>