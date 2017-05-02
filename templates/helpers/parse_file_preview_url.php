<?php
return function (string $file_name): string {
    if(mime_content_type($file_name) == 'application/pdf')
        return 'images/icon_pdf.svg';
    return $file_name;
};