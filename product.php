<?php

use Pis0sion\Docx\servlet\FooterServlet;
use Pis0sion\Docx\servlet\HeaderServlet;
use Pis0sion\Docx\servlet\PhpWordServlet;
use Pis0sion\Docx\servlet\TableServlet;
use Pis0sion\Docx\servlet\TocServlet;

require "./vendor/autoload.php";

// 实例化 PhpWord 对象
$phpWordServlet = new PhpWordServlet();
// 初始化
$phpWordServlet->init();

// 创建页面
// 设置页面边框大小颜色
$section = $phpWordServlet->newSection(['borderColor' => '161616', 'borderSize' => 6]);
// 创建页眉页脚
(new HeaderServlet($section->addHeader()))->setHeader();
(new FooterServlet($section->addFooter()))->setFooter();

// 版本内容
$version = [
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
(new TableServlet($section))->run([
    '日期' => 1800,
    '版本' => 1500,
    '说明' => 4000,
    '作者' => 1500,
], $version);
$section->addPageBreak();

// 创建目录
(new TocServlet($section))->setTOC();


// 获取json数据
$postmanJson = file_get_contents("./burg.json");
$postmanArr = json_decode($postmanJson, true);

// 获取接口数据
// postman
$postmanApis = $postmanArr['item'];

$projectVars = [];
$module_name = "默认项目列表";
$module_list = [];
// 对数据进行分类
foreach ($postmanApis as $postmanApi) {
    // 判断是否为模块
    if (array_key_exists("item", $postmanApi)) {
        $projectVars[] = [
            'module_name' => $postmanApi['name'],
            // TODO: 支持两级目录
            // 防止多级目录需要做递归
            'module_list' => $postmanApi['item'],
        ];
        continue;
    }
    // 模块列表
    $module_list[] = $postmanApi;
}

// 添加默认项目列表模块
if (count($module_list) != 0) {
    array_unshift($projectVars, compact('module_name', 'module_list'));
}

/**
 * @param array $successResponseArr
 * @return array
 */
function obtainResponse2Success(array $successResponseArr): array
{
    $successRespond = [];
    foreach ($successResponseArr as $successResponse) {
        if (isset($successResponse['code']) && $successResponse['code'] == 200) {
            $successRespond['raw'] = $successResponse['body'] ?? '{}';
            // 根据 raw 获取body
            $obtainDatum = json_decode($successRespond['raw'], true);
            $successRespond['body'] = archiving(recursionArr($obtainDatum, null));
            break;
        }
    }
    return $successRespond;
}

// 遍历
foreach ($projectVars as &$projectVar) {
    $moduleApis = &$projectVar['module_list'];

    foreach ($moduleApis as &$moduleApi) {
        // 新增字段
        $apiRequest = &$moduleApi['request'];
        $apiRequest['api_url'] = $moduleApi['request']['url']['raw'];
        $apiRequest['contentType'] = "application/json";
        $apiRequest['description'] = "接口描述";

        $apiResponse = &$moduleApi['response'];
        $apiResponse['body'] = [];
        $apiResponse['raw'] = "";

        if (count($moduleApi['response']) == true) {
            $apiResponseArr = obtainResponse2Success($moduleApi['response']);
            $apiResponse['body'] = $apiResponseArr['body'] ?? [];
            $apiResponse['raw'] = $apiResponseArr['raw'] ?? '';
        }
    }
}

$apis = [
    "apis" => $projectVars,
];
// 生成文档
(new \Pis0sion\Docx\Core())->run($section, $apis);

// 保存文件
$phpWordServlet->saveAs("./pis0sion.docx");

function recursionArr(array $arrDatum, ?string $keyString): array
{
    $re = [];
    foreach ($arrDatum as $key => $value) {
        $handleKey = $key;
        if (!empty($keyString)) {
            if (!is_int($key)) {
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

function archiving(array $inputArr): array
{
    $retResult = [];
    foreach ($inputArr as $key => $input) {
        $ret['key'] = $key;
        $ret['value'] = is_object($input) ? "Object" : $input;
        $ret['type'] = gettype($input);
        $ret['description'] = "暂无描述";
        $retResult[] = $ret;
    }
    return $retResult;
}