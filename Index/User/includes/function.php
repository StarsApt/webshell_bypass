<?php

function decrypt($data, $key)
{
    $data_1 = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $ch = ord($data[$i]);
        if ($ch < 245) {
            if ($ch > 136) {
                $data_1 .= chr($ch / 2);
            } else {
                $data_1 .= $data[$i];
            }
        }
    }
    $data_1 = base64_decode($data_1);
    $key = md5($key);
    $j = $ctrmax = 32;
    $data_2 = '';
    for ($i = 0; $i < strlen($data_1); $i++) {
        if ($j <= 0) {
            $j = $ctrmax;
        }
        $j--;
        $data_2 .=  $data_1[$i] ^ $key[$j];
    }
    return $data_2;
}

function find_data($code)
{
    $code_end = strrpos($code, "?>");
    if (!$code_end) {
        return "";
    }
    $data_start = $code_end + 2;
    $data = substr($code, $data_start, -46);
    return $data;
}

function find_key($code)
{
    // $v1 = $v2('bWQ1');
    // $key1 = $v1('??????');
    $pos1 = strpos($code, "('" . preg_quote(base64_encode('md5')) . "');");
    $pos2 = strrpos(substr($code, 0, $pos1), '$');
    $pos3 = strrpos(substr($code, 0, $pos2), '$');
    $var_name = substr($code, $pos3, $pos2 - $pos3 - 1);
    $pos4 = strpos($code, $var_name, $pos1);
    $pos5 = strpos($code, "('", $pos4);
    $pos6 = strpos($code, "')", $pos4);
    $key = substr($code, $pos5 + 2, $pos6 - $pos5 - 2);
    return $key;
}

$input_file = $argv[1]. $app.'/includes/download/'.$space.'/'.$file.".txt";
$output_file = $argv[1]. $app.'/includes/download/'.$space.'/'.$file.".txt";

$code = file_get_contents($input_file);

$data = find_data($code);
if (!$code) {
    echo '未找到加密数据', PHP_EOL;
    exit;
}

$key = find_key($code);
if (!$key) {
    echo '未找到秘钥', PHP_EOL;
    exit;
}

$decrypted = decrypt($data, $key);
$uncompressed = gzuncompress($decrypted);
if ($uncompressed) {
    $decrypted = str_rot13($uncompressed);
} else {
    $decrypted = str_rot13($decrypted);
}
file_put_contents($output_file, $decrypted);
?>