<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Trolleydienst</title>
        <meta name="description" content="Trolleydienst Verwaltung">
        <link href="../css/global.css" rel="stylesheet">
    </head>

    <body>
        <div>
            <div class="wrapper_center">
                <a id="logo"><img src="../images/logo-trolleydienst.png"></a>
            </div>
        </div>
        <div>
            <header class="wrapper_center">
                <h2 id="site_name">Trolleydienst</h2>
            </header>
        </div>
        <nav>
            <div class="wrapper_center">
                <ul id="main_nav">
                    <?php foreach ($placeholder['navigation'] as $page): ?>
                    <li>
                        <a href="<?php echo $page['link']; ?>" <?php echo (isset($page['active'])) ? 'class="active"' : ''; ?>>
                            <?php echo $page['name']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <div class="wrapper_center">
            <main>
                <?php echo $placeholder['content']; ?>
            </main>
            <footer>
                <div class="wrapper_center">
                    FOOTER
                </div>
            </footer>
        </div>

    </body>
</html>