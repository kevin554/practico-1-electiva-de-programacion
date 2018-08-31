<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">
                <img src="img/pinterest.png" width="30" height="30" alt="pinterest logo">
            </a>

            <!--<a class="navbar-brand" href="#">Navbar</a>-->
<!--            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>-->

            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2 bg-light" type="search" placeholder="Search" aria-label="Search">
            </form>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Following</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Explore</a>
                    </li>
                </ul>
            </div>
        </nav>

        <?php
        include_once 'dao/dal/Connection.php';
        include_once './dao/dto/pins.php';
        include_once './dao/bll/pinsBLL.php';

        $pinBll = new pinsBLL();
//        $tableroBll = new tablerosBLL();
//        $tableroBll->insert("Marvel");
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Url</th>
                    <th>Tablero id</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pinList = $pinBll->selectAll();
                foreach ($pinList as $pin) {
                    ?>
                    <tr>
                        <td><?php echo $pin->getId(); ?></td>
                        <td><?php echo $pin->getTitle(); ?></td>
                        <td><?php echo $pin->getImage(); ?></td>
                        <td><?php echo $pin->getUrl(); ?></td>
                        <td><?php echo $pin->getBoardFk(); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
