<?php


$config =& get_config();
echo file_get_contents($config['base_url'].'login/error_page?heading='.$heading.'&user_id=xxxxx');

