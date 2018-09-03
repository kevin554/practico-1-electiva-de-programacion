<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <link href="css/index.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once './dao/dal/Connection.php';
        include_once './dao/dto/pins.php';
        include_once './dao/bll/pinsBLL.php';
        include_once './dao/dto/boards.php';
        include_once './dao/bll/boardsBLL.php';

        $boardBll = new boardsBLL();

        $pin = null;

        if (isset($_REQUEST["id"])) {
            $id = $REQUEST["id"];
            $pinBll = new pinsBLL();
            $pin = $pinBll->select($id);
        }
        ?>
        
        <nav class="navbar navbar-expand-md border-bottom navbar-light">
            <a class="navbar-brand order-1" href="#index.php">
                <img src="img/pinterest.png" width="30" height="30" alt="pinterest logo">
            </a>

        </nav>
        <div class="container">
            <div class="col-md-6 offset-md-3">
                <h1>
                    Crear pin
                </h1>
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="task" value="<?php echo ($pin == null) ? "insert" : "update"; ?>"/>
                    <input type="hidden" name="id"  value="<?php
                    if ($pin != null) {
                        echo $pin->getId();
                    }
                    ?>"/>
                    <div class="form-group">
                        <label>Titulo:</label>
                        <input class="form-control" type="text" name="title" required="required" value="<?php
                        if ($pin != null) {
                            echo $pin->getTitle();
                        }
                        ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Url:</label>
                        <input class="form-control" type="text" name="url" required="required" value="<?php
                        if ($pin != null) {
                            echo $pin->getUrl();
                        }
                        ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Imagen:</label>
                        <!-- image-preview-filename input [CUT FROM HERE]-->
                        <div class="input-group image-preview">
                            <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                            <span class="input-group-btn">
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                    <span class="glyphicon glyphicon-remove"></span> Clear
                                </button>
                                <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input">
                                    <span class="glyphicon glyphicon-folder-open"></span>
                                    <span class="image-preview-input-title">Browse</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="file"/> <!-- rename it -->
                                </div>
                            </span>
                        </div><!-- /input-group image-preview [TO HERE]--> 
                    </div>

                    <div class="form-group">
                        <label>Tablero:</label>
                        <select class="form-control" name="board"  required="required">
                            <option value="">Seleccione el tablero</option>
                            <?php
                            $boardList = $boardBll->selectAll();
                            foreach ($boardList as $board) {
                                ?>
                                <option value="<?php echo $board->getId(); ?>"><?php echo $board->getName(); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Crear"/>
                        <a href="index.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
            });

            $(document).on('click', '#close-preview', function () {
                $('.image-preview').popover('hide');
                // Hover befor close the preview
                $('.image-preview').hover(
                        function () {
                            $('.image-preview').popover('show');
                        },
                        function () {
                            $('.image-preview').popover('hide');
                        }
                );
            });

            $(function () {
                // Create the close button
                var closebtn = $('<button/>', {
                    type: "button",
                    text: 'x',
                    id: 'close-preview',
                    style: 'font-size: initial;',
                });
                closebtn.attr("class", "close pull-right");
                // Set the popover default content
                $('.image-preview').popover({
                    trigger: 'manual',
                    html: true,
                    title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
                    content: "There's no image",
                    placement: 'bottom'
                });
                // Clear event
                $('.image-preview-clear').click(function () {
                    $('.image-preview').attr("data-content", "").popover('hide');
                    $('.image-preview-filename').val("");
                    $('.image-preview-clear').hide();
                    $('.image-preview-input input:file').val("");
                    $(".image-preview-input-title").text("Browse");
                });
                // Create the preview image
                $(".image-preview-input input:file").change(function () {
                    var img = $('<img/>', {
                        id: 'dynamic',
                        width: 250,
                        height: 200
                    });
                    var file = this.files[0];
                    var reader = new FileReader();
                    // Set preview image into the popover data-content
                    reader.onload = function (e) {
                        $(".image-preview-input-title").text("Change");
                        $(".image-preview-clear").show();
                        $(".image-preview-filename").val(file.name);
                        img.attr('src', e.target.result);
                        $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
                    }
                    reader.readAsDataURL(file);
                });
            });
        </script>
    </body>
</html>
