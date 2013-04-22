<?php

global $config;
dbm::init($config);


file_put_contents($output_path,'success');
?>