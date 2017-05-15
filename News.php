<?php
$ShowNews=1;
if(!empty($_SESSION)) {
    if (isset($_GET['DowID'])) {

        $stmt_file = $database_pdo->prepare(
            'SELECT ID, Bezeichnung, Dateiname, ServerPfadname
            FROM newsletter
            WHERE ID = :id_file'
        );

        $stmt_file->execute(
            array(':id_file' => (int)$_GET['DowID'])
        );
        $file = $stmt_file->fetch();

        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename=' . $file['Dateiname']);

        ob_clean();
        flush();
        readfile('./News/' . $file['ServerPfadname']);
    }

    if (isset($_GET['DelID']) && !empty($_SESSION)) {

        $stmt_file_info = $database_pdo->prepare(
            'SELECT ID, Bezeichnung, Dateiname, ServerPfadname
            FROM newsletter
            WHERE ID = :id_file'
        );

        $stmt_file_info->execute(
            array(':id_file' => (int)$_GET['DelID'])
        );

        $file_info = $stmt_file_info->fetch();

        if(unlink('./News/' . $file_info['ServerPfadname'])) {
            $stmt_file_info_delete = $database_pdo->prepare(
                'DELETE FROM newsletter WHERE ID = :id_file'
            );

            $stmt_file_info_delete->execute(
                array(':id_file' => (int)$_GET['DelID'])
            );
        }
    }

    if (isset($_POST['SaveNews'])) {
        if (is_dir("./News") == false && !mkdir("./News"))
            exit('Der Ordner News kann nicht angelegt werden!');

        $mFilename = uniqid();
        $mFilename .= ".";
        $mFilename .= pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        if (file_exists('./News/' . $mFilename))
            exit($_FILES["file"]["name"] . ' existiert schon!');
        else
            move_uploaded_file($_FILES["file"]["tmp_name"], './News/' . $mFilename);

        $stmt_id_file_last = $database_pdo->prepare(
            'SELECT coalesce(MAX(ID),0) + 1 AS ID FROM newsletter'
        );

        $stmt_id_file_last->execute();
        $id_file_last = $stmt_id_file_last->fetch();
        $ID = ($id_file_last['ID'] == 0) ? 1 : (int)$id_file_last['ID'];

        $stmt_insert_file = $database_pdo->prepare(
            'INSERT INTO newsletter (ID, Bezeichnung, Dateiname, ServerPfadname, newsletter_typ)
            VALUES (:id_file, :label_file, :name_file, :path_file, :type_news)'
        );

        $stmt_insert_file->execute(
            array(
                ':id_file' => $ID,
                ':label_file' => filter_filename($_POST['Bezeichnung']),
                ':name_file' => $_FILES["file"]["name"],
                ':path_file' => $mFilename,
                ':type_news' => (int)$_POST['TypeNews']
            )
        );
        if ($stmt_insert_file->rowCount() != 1)
            exit('Infos konnte nicht eingefügt werden!');
    }

    if (isset($_POST['SaveEditNews'])) {

        $stmt_update_file = $database_pdo->prepare(
            'UPDATE newsletter 
            SET Bezeichnung = :label_file, newsletter_typ = :type_news
            WHERE ID = :id_news'
        );

        $stmt_update_file->execute(
            array(
                ':label_file' => filter_filename($_POST['Bezeichnung']),
                ':type_news' => (int)$_POST['TypeNews'],
                ':id_news' => (int)$_POST['NewsID']
            )
        );

        if ($stmt_update_file->rowCount() != 1)
            exit ('Infos konnte nicht gespeichert werden!');
    }

    if (isset($_GET['EditDS'])) {
        $ShowNews = 0;

        $stmt_file = $database_pdo->prepare(
            'SELECT ID, Bezeichnung, Dateiname, ServerPfadname, coalesce(newsletter_typ,0) AS newsletter_typ
            FROM newsletter
            WHERE ID = :id_file'
        );

        $stmt_file->execute(
            array(':id_file' => (int)$_GET['EditDS'])
        );

        $file = $stmt_file->fetch();
        $guide_selected = '';
        $oezi_selected = '';
        $literature_cart_selected = '';
        $literature_table_selected = '';

        switch ($file['newsletter_typ']) {
            case -1:
                $guide_selected = 'selected';
                break;
            case 0:
                $oezi_selected = 'selected';
                break;
            case 1:
                $literature_cart_selected = 'selected';
                break;
            case 2:
                $literature_table_selected = 'selected';
                break;
        }

        $mHTML .=
            '<h3>Information ' . $file['Bezeichnung'] . ' bearbeiten</h3>
            <fieldset style="width:470px">
                <legend>News</legend>
                <form action="index.php?Type=Infos" method="post" enctype="multipart/form-data">
                    <table border=0 cellspacing=0>
                        <colgroup>
                            <COL WIDTH=150>
                            <COL WIDTH=150>
                        </colgroup>
                        <input type="hidden" name="NewsID" size=30 value="' . $file['ID'] . '">
                        <tr>
                            <td>Bezeichnung:</td>
                            <td><input type="Text" name="Bezeichnung" size=30 value="' . $file['Bezeichnung'] . '"></td>
                        </tr>
                        <tr>
                            <td>Typ:</td>
                            <td>
                            <select name="TypeNews">
                            <option value="-1" ' . $guide_selected . '>Anleitung</option>
                            <option value="0" '. $oezi_selected .'>Özi</option>
                            <option value="1" ' . $literature_cart_selected . '>Trolley</option>
                            <option value="2" ' . $literature_table_selected . '>Infostand</option>
                            </select>
                            </td>
                        </tr>
                    </table>
                    <input type="Submit" name="SaveEditNews" value="Speichern">
                </form>
                <a href="index.php?Type=Infos&DelID=' . $file['ID'] . '">Löschen</a>
            </fieldset></br>';
    }

    if (isset($_POST['NewNews'])) {
        $mHTML .=
            '<h3>Neue Information</h3>
            <fieldset style="width:470px">
                <legend>News</legend>
                <form action="index.php?Type=Infos" method="post" enctype="multipart/form-data">
                    <table border=0 cellspacing=0>
                        <colgroup>
                            <COL WIDTH=150>
                            <COL WIDTH=150>
                        </colgroup>
                        <tr>
                            <td>Bezeichnung:</td>
                            <td><input type="Text" name="Bezeichnung" size=30></td>
                        </tr>
                        <tr>
                            <td>Typ:</td>
                            <td>
                            <select name="TypeNews">
                            <option value="-1">Anleitung</option>
                            <option value="0" selected>Özi</option>
                            <option value="1">Trolley</option>
                            <option value="2">Infostand</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Datei:</td>
                            <td><input type="file" name="file" id="file"></td>
                        </tr>
                    </table>
                    <input type="Submit" name="SaveNews" value="Speichern">
                </form>
            </fieldset></br>';
        $ShowNews = 0;
    }
}

if ($ShowNews == 1) {
    $mHTML.="<h3>News</h3>";
    if ($_SESSION['admin'] == 1)
    {
        $mHTML.="<form action=\"index.php?Type=Infos\" method=\"post\">";
        $mHTML.="<input type=\"submit\" name=\"NewNews\" Value=\"Neue Information\">";
        $mHTML.="</form></br>";
    }

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
}

/**
 * @param string $filename
 * @return string
 */
function filter_filename($filename) {
    $filename_filtered = preg_replace('/[^A-Za-z0-9\-$]/', '', $filename);

    $filename_valid = filter_var(
        $filename_filtered,
        FILTER_VALIDATE_REGEXP,
        array("options"=>array("regexp"=>"/^[a-zA-Z]/"))
    );

    if($filename_valid === FALSE)
        return 'unknown';
    else
        return $filename_valid;
}

?>