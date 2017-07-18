<?php $active_page = include 'templates/helpers/active_page.php'; ?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title><?php echo APPLICATION_NAME; ?> - <?php echo CONGREGATION_NAME; ?></title>
        <meta name="description" content="Trolleydienst Verwaltung">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="vendor/components/font-awesome/css/font-awesome.min.css">
        <link href="/css/global.css" rel="stylesheet">
    </head>

    <body>
        <div>
            <div class="wrapper-center">
                <a id="logo"><img src="../images/logo-trolleydienst.png"></a>
            </div>
        </div>
        <div>
            <header class="wrapper-center">
                <h1 id="site-name"><?php echo APPLICATION_NAME; ?> <small><?php echo CONGREGATION_NAME; ?></small></h1>
            </header>
        </div>
        <nav>
            <div class="wrapper-center">
                <ul id="main-nav">
                    <?php if(!empty($_SESSION)) : ?>
                    <li>
                        <a href="shift.php?id_shift_type=1" class="<?php $active_page('shift.php');?>">Trolley</a>
                    </li>
                    <li>
                        <a href="info.php" class="<?php $active_page('info.php');?>">Infos</a>
                    </li>
                    <li>
                        <a href="profile.php" class="<?php $active_page('profile.php');?>">Profil</a>
                    </li>
                    <?php if($_SESSION['is_admin']) : ?>
                    <li>
                        <a href="shift-type.php" class="<?php $active_page('shift-type.php');?>">Schichttyp</a>
                    </li>
                    <li>
                        <a href="user.php" class="<?php $active_page('user.php');?>">Teilnehmer</a>
                    </li>
                    <li>
                        <a href="email.php" class="<?php $active_page('email.php');?>">E-Mail</a>
                    </li>
                    <?php endif;?>
                    <li style="float:right">
                        <a href="/?logout">Abmelden</a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </nav>
        <div class="wrapper-center">
            <main>
                <?php echo $placeholder['content']; ?>
            </main>
            <footer>
                <div class="wrapper-center">
                </div>
            </footer>
        </div>

    </body>
</html>