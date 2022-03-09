<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $basePath?>/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Website</title>
</head>
<body>
    <div class="wrapper">
        <div>
            <div class="row row-collapse">
                <div id="admin-menu" class="col max-w-350 full-height min-h-100">
                    <?php require dirname(__DIR__)."/blocks/main-sidebar.php"?>
                </div>
                <div id="admin-content" class="col">
                    <?php require dirname(__DIR__)."/blocks/content.php"?>                 
                </div>
            </div>
        </div>
    </div>
</body>
</html>