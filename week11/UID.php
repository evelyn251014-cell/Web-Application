<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$code = '';

for ($i = 0; $i < 6; $i++) {
    $code .= $characters[rand(0, strlen($characters) - 1)];
}  

$uniqueCode = $code . date('YmdHis') . "_" . $code;

echo $uniqueCode;

?>