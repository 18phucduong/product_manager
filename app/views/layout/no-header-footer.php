<?php  
    session_start();
    if (isset($_SESSION['dataPage']) && !empty($_SESSION['dataPage']) ) {    
        $data = $_SESSION['dataPage'];
    }
    unset($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo getUrlFromBasePath('/assets/css/library.css')?>">
    <link rel="stylesheet" href="<?php echo getUrlFromBasePath('/assets/css/login.css')?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script> -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
    <script  src="assets/js/validation/login.js" type="text/javascript"></script>
    <title><?php echo !empty($page['title']) ? $page['title'] : 'Website';?></title>
</head>
<body>
    
    <?php view($path,$data['dataView'])?>                 
                
</body>
</html>