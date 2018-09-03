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
        $con = new Connection();

        $task = "list";
        if (isset($_REQUEST["task"])) {
            $task = $_REQUEST["task"];
        }

        switch ($task) {
            case "insert":
                if (isset($_REQUEST["title"]) && isset($_FILES["file"]) && isset($_REQUEST["board"])) {
                    $title = $_REQUEST["title"];
                    $url = $_REQUEST["url"];
                    $imageName = $_FILES['file']['name']; /* name and format of the upload image */
                    $boardFk = $_REQUEST["board"];

                    $generatedId = $pinBll->insert($title, $imageName, $url, $boardFk);

                    echo $generatedId;
                    $pinBll->update($generatedId, $title, $generatedId, $url, $boardFk);

                    $tmp_name = $_FILES['file']['tmp_name']; /* hosted in xampp */
                    $local_image = "img/";
                    move_uploaded_file($tmp_name, $local_image . $generatedId);
                }
                break;
        }
        ?>

        <nav class="navbar navbar-expand-md border-bottom navbar-light">
            <a class="navbar-brand order-1" href="#">
                <img src="img/pinterest.png" width="30" height="30" alt="pinterest logo">
            </a>

            <form class="form-inline w-100 order-2">
                <div class="input-group w-100">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="background: #efefef">
                            <img src="img/searcher.png" width="30" height="30" alt="pinterest logo">
                        </span>
                    </div>
                    <input type="text" class="form-control border-left-0 font-weight-bold" style="background: #efefef" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>

            <div class="collapse navbar-collapse order-3" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="formNewPin.php">Nuevo pin<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="boards.php">Ver tableros</a>
                    </li>
                </ul>
            </div>
        </nav>

        <?php
        include_once 'dao/dal/Connection.php';
        include_once './dao/dto/pins.php';
        include_once './dao/bll/pinsBLL.php';

        $pinBll = new pinsBLL();
        ?>

        <div class="container mt-5">
            <div class="row">

                <?php
                $pinList = $pinBll->selectAll();
                foreach ($pinList as $pin) {
                    ?>
                    <div class="col-sm">
                        <div class="pin">
                            <img src="img/<?php echo $pin->getImage(); ?>" alt="image" class="rounded img-fluid" onclick="showPin(<?php echo "'".$pin->getUrl()."'"; ?>)"/>
                            <span class="clearfix"></span>
                            <b class="float-left"><?php echo $pin->getTitle(); ?></b>
                            <p class="float-right">...</p>
                            <div class="dropdown float-right">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dropdown button
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="modal fade" id="addBoardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cambiar nombre del tablero</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php" method="POST">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirm-button">Cambiar</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.pinasd').on('click', function () {
                    alert("pin");
                });
            });

            function showPin(pin) {
                window.location.href = "http://" + pin;
            }
        </script>
    </body>
</html>
