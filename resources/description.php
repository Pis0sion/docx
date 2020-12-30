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

// version format
const VersionFormatter = [
    '日期' => 1800,
    '版本' => 1500,
    '说明' => 4000,
    '作者' => 1500,
];

// versions
const ProjectVersion = [
    [
        'param' => "2020/4/8",
        'namely' => "V0.0.1",
        'isBool' => "新增文档",
        'desc' => "老詹",
    ],
    [
        'param' => "2020/4/10",
        'namely' => "V0.0.2",
        'isBool' => "格式调整及描述修改",
        'desc' => "小张",
    ],
    [
        'param' => "2020/5/8",
        'namely' => "V1.0.0",
        'isBool' => "新增鉴权",
        'desc' => "小张、老詹",
    ],
    [
        'param' => "2020/5/11",
        'namely' => "V1.0.1",
        'isBool' => "修改鉴权",
        'desc' => "小张、老詹",
    ],
    [
        'param' => "",
        'namely' => "",
        'isBool' => "",
        'desc' => "",
    ],
    [
        'param' => "",
        'namely' => "",
        'isBool' => "",
        'desc' => "",
    ],
    [
        'param' => "",
        'namely' => "",
        'isBool' => "",
        'desc' => "",
    ],
    [
        'param' => "",
        'namely' => "",
        'isBool' => "",
        'desc' => "",
    ],
];


if (!function_exists("halt")) {
    function halt(array $parameters)
    {
        file_put_contents("./out.json", json_encode($parameters, JSON_UNESCAPED_UNICODE));
        die();
    }
}