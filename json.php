<?php

require "./vendor/autoload.php";

$oArr = file_get_contents("./postman.json");

$inputArr = json_decode($oArr, true);

// 默认为空
// 递归
function recursionArr(array $arrDatum, ?string $keyString): array
{
    $re = [];
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
            $re[$handleKey] = new stdClass();
            $re = array_merge($re, recursionArr($value, $handleKey));
            continue;
        }
        $re[$handleKey] = $value;
    }
    return $re;
}

$result = recursionArr($inputArr, null);

/**
 * @param array $inputArr
 * @return array
 */
function archiving(array $inputArr): array
{
    $retResult = [];
    foreach ($inputArr as $key => $input) {
        $ret['key'] = $key;
        $ret['value'] = $input;
        $ret['type'] = gettype($input);
        $ret['description'] = "暂无描述";
        $retResult[] = $ret;
    }
    return $retResult;
}

