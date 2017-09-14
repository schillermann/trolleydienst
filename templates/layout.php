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
                <a href="/" id="logo"><img src="../images/logo-trolleydienst.png"></a>
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
                    <?php foreach ($placeholder['shift_types'] as $shift_type): ?>
                    <li>
                        <a href="shift.php?id_shift_type=<?php echo $shift_type['id_shift_type'];?>" class="<?php echo $active_page('shift.php', 'id_shift_type=' . $shift_type['id_shift_type']);?>"><?php echo $shift_type['name'];?></a>
                    </li>
                    <?php endforeach;?>
                    <li>
                        <a href="report.php" class="<?php echo $active_page('report.php');?>">Bericht</a>
                    </li>
                    <li>
                        <a href="info.php" class="<?php echo $active_page('info.php');?>">Info</a>
                    </li>
                    <li>
                        <a href="profile.php" class="<?php echo $active_page('profile.php');?>">Profil</a>
                    </li>
                    <?php if($_SESSION['is_admin']) : ?>
                    <li>
                        <a href="shift-type.php" class="<?php echo $active_page('shift-type.php');?>">Schichtart</a>
                    </li>
                    <li>
                        <a href="user.php" class="<?php echo $active_page('user.php');?>">Teilnehmer</a>
                    </li>
                    <li>
                        <a href="email.php" class="<?php echo $active_page('email.php');?>">E-Mail</a>
                    </li>
                    <li>
                        <a href="history.php" class="<?php echo $active_page('history.php');?>">Verlauf</a>
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
                <?php echo $placeholder['template']; ?>
            </main>
            <footer>
                <nav>
                    <ul id="footer-nav">
                        <li><a href="//trolleydienst.de/feedback.php" target="_blank">Feedback</a></li>
                        <li><a href="licence.php">Licence</a></li>
                        <li><a href="https://github.com/schillermann/trolleydienst" target="_blank" id="link-github">GitHub</a></li>
                        <li><a href="https://github.com/schillermann/trolleydienst/issues" target="_blank">Issues</a></li>
                    </ul>
                </nav>
            </footer>
        </div>
        <script type="text/javascript" src="js/note_box.js"></script>
    </body>
</html>