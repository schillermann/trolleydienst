<?php
return (isset($_GET['id_schedule']) && !empty($_GET['id_schedule'])) ? (int)$_GET['id_schedule'] : 0;