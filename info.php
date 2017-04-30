<?php
require 'includes/init_page.php';
$database_pdo = include 'includes/database_pdo.php';

// -1 - +2

$database_pdo->prepare(
    'SELECT ID, Bezeichnung, Dateiname, ServerPfadname
            FROM newsletter 
            WHERE coalesce(newsletter_typ,0) = ' . $i . '
            ORDER BY Bezeichnung'
);

for ($i = -1; $i <= 1; $i++) {

    $mHeader="";
    $mBild="";
    if ($i == -1)
    {
        $mHeader = '<b>' . CONGREGATION_NAME . '</b> - Infos rund um die Website';
        $mBild="New_Anleitung.png";
    }

    if ($i == 0)
    {
        $mHeader="<b>ÖZi</b> - Die News vom öffentlichen Zeugnisgeben";
        $mBild="News_Oezi.png";
    }

    if ($i == 1)
    {
        $mHeader="<b>Trolley</b> - Alle Infos, Merkblätter und Gebiete";
        $mBild="News_Trolley.png";
    }

    if ($i == 2)
    {
        $mHeader="<b>Infostand</b> - Alle Infos, Merkblätter und Gebiete";
        $mBild="News_Infostand.png";
    }


    $mHTML.="<div class=\"NewsHeader\" style=\"margin:10px 25px 20px 10px;color:#5F497A;border-bottom:solid 1px #5F497A;\">";
    $mHTML.=$mHeader;
    $mHTML.="</div>";

    $sql = 'SELECT ID, Bezeichnung, Dateiname, ServerPfadname
            FROM newsletter 
            WHERE coalesce(newsletter_typ,0) = ' . $i . '
            ORDER BY Bezeichnung';
    if ($i == 0)
        $sql .= " DESC ";

    $stmt_file_list = $database_pdo->prepare($sql);

    $stmt_file_list->execute();

    $mHTML.="<div class=\"News\">";

    while($file = $stmt_file_list->fetch()) {
        $mHTML .=
            '<div class="div_NewsItem">
                    <div class="div_NewsItem_innerleft">
                        <a href="index.php?Type=Infos&DowID=' . $file['ID'] . '">
                            <img src="images/' . $mBild . '" style="max-height:70px;">
                        </a>
                    </div>';

        $Link = 'index.php?Type=Infos&DowID=' . $file['ID'];
        if ($_SESSION['admin'] == 1)
            $Link="index.php?Type=Infos&EditDS=" . $file['ID'];

        $mHTML .=
            '<div class="div_NewsItem_innerleft">
                    <a href="' . $Link . '">
                        <p>' . $file['Bezeichnung'] . '</p>
                    </a>
                </div>
                <div class="Div_Clear"></div>
                </div>';
    }
    $mHTML .= '<div class="Div_Clear"></div></div>';
}


$template_placeholder = array();

$render_page = include 'includes/render_page.php';
echo $render_page($template_placeholder);