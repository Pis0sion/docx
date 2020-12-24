<?php

// 空描述
const EmptyDescriptions = "暂无描述";

// postman 成功相应码
const SuccessPostManCode = 200;

// postman 成功默认的空数据
const SuccessPostManRaw = "{}";

// project 模块默认列表
const ProjectDefaultList = "默认列表";

// post默认的接口描述
const ApiDefaultDescription = "接口描述";

// 空url
const ApiDefaultEmptyUrl = "http://{{api_url}}";

// 默认的ContentType
const DefaultContentType = "application/json";

// 默认Raw的ContentType
const DefaultRawContentType = "text/plain";

// content-type
const ContentTypeMap = [
    'formdata' => 'multipart/form-data',
    'urlencoded' => 'application/x-www-form-urlencoded',
    'json' => 'application/json',
    'javascript' => 'application/javascript',
    'html' => 'text/html',
    'xml' => 'application/xml',
];


if (!function_exists("halt")) {
    function halt(array $parameters)
    {
        file_put_contents("./out.json", json_encode($parameters, JSON_UNESCAPED_UNICODE));
        die();
    }
}