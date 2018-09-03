<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="js/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/index.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once './dao/dal/Connection.php';
        include_once './dao/dto/boards.php';
        include_once './dao/bll/boardsBLL.php';

        $boardBll = new boardsBLL();

        $task = "list";
        if (isset($_REQUEST["task"])) {
            $task = $_REQUEST["task"];
        }
        
        switch ($task) {
            case "insertBoard":
                if (isset($_REQUEST["name"])) {
                    $name = $_REQUEST["name"];
                    $boardBll->insert($name);
                }

                break;
                
            case "editingBoard":
                if (isset($_REQUEST["id"])) {
                    $id = $_REQUEST["id"];
                    $board = $boardBll->select($id);
                }
                
                break;

            case "updateBoard":
                echo $_REQUEST["name"];
//                if (isset($_REQUEST["name"])) {
//                    $name = $_REQUEST["name"];
//                    $boardBll->insert($name);
//                }

                break;

            case "delete":
                if (isset($_REQUEST["id"])) {
                    $id = $_REQUEST["id"];
                    $boardBll->delete($id);
                }

                break;
        }

        if ($task != 'search') {
            $boardList = $boardBll->selectAll();
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
                    <!--<li class="nav-item">-->
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#addBoardModal">Nuevo tablero</button>
                    <!--<a class="nav-link" href="formNewPin.php">Nuevo tablero<span class="sr-only">(current)</span></a>-->
                    <!--</li>-->
<!--                    <li class="nav-item active">
                        <a class="nav-link" href="boards.php">Ver tableros</a>
                    </li>-->
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="col-md-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($boardList as $board) {
                            ?>
                            <tr>
                                <td><?php echo $board->getId(); ?></td>
                                <td><?php echo $board->getName(); ?></td>
                                <td>
                                    <form action="board.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $board->getId(); ?>"/>
                                        <input type="submit" class="btn btn-primary" value="Ver pines"/>
                                    </form>
                                </td>
<!--                                <td>
                                    <form action="boards.php" method="POST">
                                        <input type="hidden" name="task" value="editingBoard"/>
                                        <input type="hidden" name="id" value="<?php echo $board->getId(); ?>"/>
                                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#editBoardModal"  data-board="<?php echo $board->getName(); ?>">Editar</button>
                                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#editBoardModal">Editar</button>
                                    </form>
                                </td>-->
                                <td>
                                    <form method="POST" action="boards.php">
                                        <input type="hidden" name="task" value="delete"/>
                                        <input type="hidden" name="id" value="<?php echo $board->getId(); ?>"/>
                                        <input type="submit" class="btn btn-danger" value="Eliminar"/>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="modal fade" id="addBoardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="boards.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear un nuevo tablero</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="task" value="insertBoard"/>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="confirm-button">Crear tablero</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editBoardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="boards.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cambiar nombre del tablero</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="task" value="updateBoard"/>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" value="<?php
                                if ($board != null) {
                                    echo $board->getName();
                                }
                                ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="confirm-button">Cambiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
//            $(document).ready(function () {
//            });
//
            function showPinsOfBoard(board) {
                window.location.href = "board.php?id=" + board;
            }
//
//            $('#editBoardModal').on('show.bs.modal hide.bs.modal', function (event) {
//                var modal = $(this);
//
////                var $activeElement = $(document.activeElement);
////                if ($activeElement.is('[data-toggle], [data-dismiss]')) {
////                    if (event.type === 'hide') {
////                        if ($activeElement[0].id == "confirm-button")
////                            // HERE WE GO
////                            return;
////                    }
////                }
//
//                var button = $(event.relatedTarget);
//                var recipient = button.data('board');
//
//                modal.find('.modal-body input').val(recipient);
//
//            })

//            $('#addBoardModal').on('hide.bs.modal', function (event) {
//                var modal = $(this);
//
//                var $activeElement = $(document.activeElement);
//                if ($activeElement.is('[data-toggle], [data-dismiss]')) {
//                    if (event.type === 'hide') {
//                        if ($activeElement[0].id == "confirm-button")
//                            alert("insert " + modal.find('.modal-body input').val());
//                            // HERE WE GO INSERTING THE BOARD
//                            return;
//                    }
//                }
//            })

        </script>
    </body>
</html>
