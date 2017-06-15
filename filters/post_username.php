<?php
return filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
