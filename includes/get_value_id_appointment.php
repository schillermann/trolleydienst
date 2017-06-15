<?php
return (isset($_GET['id_appointment']) && !empty($_GET['id_appointment'])) ? (int)$_GET['id_appointment'] : 0;