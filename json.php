<?php

require "./vendor/autoload.php";

$oArr = '{
    "errorCode": "SVCAPI_FNT_0000000",
    "errorMessage": "Success",
    "responseResult": {
        "result": "退出成功"
    }
}';

$inputArr = json_decode($oArr, true);

// 默认为空
// 递归
function recursionArr(array $arrDatum, ?string $keyString): array
{
    static $re = [];
    foreach ($arrDatum as $key => $value) {
        $handleKey = $key;
        if (!empty($keyString)) {
            if (!is_int($handleKey)) {
                $handleKey = $keyString . "." . $handleKey;
            } else {
                $handleKey = $keyString;
            }
        }
        if (is_array($value)) {
            recursionArr($value, $handleKey);
            continue;
        }
        $re[$handleKey] = $value;
    }
    return $re;
}

$result = recursionArr($inputArr, null);

var_dump($result);
