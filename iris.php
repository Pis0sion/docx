<?php

require "./vendor/autoload.php";

// 获取json数据
$postmanJson = file_get_contents("./postman.json");
$postmanArr = json_decode($postmanJson, true);

// 获取接口数据
// postman
$postmanApis = $postmanArr['item'];

$projectVars = [];
$module_name = "默认项目列表";
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
    $projectVars[] = compact('module_name', 'module_list');
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

file_put_contents("./out.json", json_encode($projectVars, JSON_UNESCAPED_UNICODE));