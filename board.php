<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="js/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/index.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once './dao/dal/Connection.php';
        include_once './dao/dto/pins.php';
        include_once './dao/bll/pinsBLL.php';
        
        $pinBll = new pinsBLL();
        
        if (isset($_REQUEST["id"])) {
            $boardId = $_REQUEST["id"];
        }
        
        $task = "list";
        if (isset($_REQUEST["task"])) {
            $task = $_REQUEST["task"];
        }
        
        if ($task != 'search') {
            $pinList = $pinBll->selectOfBoard($boardId);
        }
        ?>
        <div class="container mt-5">
            <div class="row">
                <?php
                foreach ($pinList as $pin) {
                    ?>
                    <div class="col-sm">
                        <div class="pin" onclick="showPin(<?php echo $pin->getId(); ?>)">
                            <img src="img/<?php echo $pin->getImage(); ?>" alt="image" class="rounded img-fluid"/>
                            <span class="clearfix"></span>
                            <b class="float-left"><?php echo $pin->getTitle(); ?></b>
                            <p class="float-right">...</p>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
