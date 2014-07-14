<?php


$config =& get_config();
echo curl_get_file_contents($config['base_url'].'login/error_page?heading='.$heading.'&user_id=xxxxx');

