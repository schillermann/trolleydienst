<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Trolleydienst</title>
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
                <h2 id="site-name">Trolleydienst</h2>
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