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
$postmanJson = file_get_contents("./postman.json");
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
            'module_list' => $postmanApi['item'],
        ];
        continue;
    }
    // 模块列表
    $module_list[] = $postmanApi;
}

// 判断是否为空
if (count($module_list) != 0) {
    array_unshift($projectVars, compact('module_name', 'module_list'));
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
    }
}

$apis = [
    "apis" => $projectVars,
];
// 生成文档
(new \Pis0sion\Docx\Core())->run($section, $apis);

// 保存文件
$phpWordServlet->saveAs("./pis0sion.docx");