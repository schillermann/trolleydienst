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
                    <?php foreach ($placeholder['navigation'] as $page): ?>
                    <li>
                        <a href="<?php echo $page['link']; ?>" <?php echo (isset($page['active'])) ? 'class="active"' : ''; ?>>
                            <?php echo $page['name']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <?php if(!empty($_SESSION)) : ?>
                    <li style="float:right"><a href="/?logout">Abmelden</a></li>
                    <?php endif; ?>
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