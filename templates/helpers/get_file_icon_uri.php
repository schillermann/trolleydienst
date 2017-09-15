<?php
return function (string $mime_type): string {
    if($mime_type == 'application/pdf')
        return 'images/icon_pdf.svg';
    return 'images/icon_image.svg';
};