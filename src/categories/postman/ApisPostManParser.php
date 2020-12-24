<?php


namespace Pis0sion\Docx\categories\postman;

use stdClass;

/**
 * Class ApisPostManParser
 * @package Pis0sion\Docx\categories\postman
 */
class ApisPostManParser
{
    /**
     * 解析字段并且生成文档
     * @param string $postmanJson
     * @return array
     */
    public function parse2RenderDocx(string $postmanJson): array
    {
        $postmanArr = json_decode($postmanJson, true);
        return $this->organizeProjectVars2Specifications($this->arrange2ClassifyApis($postmanArr));
    }

    /**
     * 编排接口数据并且分类
     * @param array $postmanArr
     * @return array
     */
    protected function arrange2ClassifyApis(array $postmanArr): array
    {
        // 获取接口数据
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
        return $projectVars;
    }

    /**
     * 整理数据到特定规范
     * @param array $projectVars
     * @return array
     */
    protected function organizeProjectVars2Specifications(array $projectVars): array
    {
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
                    $apiResponseArr = $this->obtainResponse2Success($moduleApi['response']);
                    $apiResponse['body'] = $apiResponseArr['body'] ?? [];
                    $apiResponse['raw'] = $apiResponseArr['raw'] ?? "{}";
                }
            }
        }
        return $projectVars;
    }

    /**
     * 获取成功的响应数据并且整理
     * @param array $successResponseArr
     * @return array
     */
    protected function obtainResponse2Success(array $successResponseArr): array
    {
        $successRespond = [];
        foreach ($successResponseArr as $successResponse) {
            if (isset($successResponse['code']) && $successResponse['code'] == 200) {
                $successRespond['raw'] = $successResponse['body'] ?? '{}';
                // 根据 raw 获取body
                $obtainDatum = json_decode($successRespond['raw'], true);
                $successRespond['body'] = $this->organizeDatum2Kv($this->recursionArr($obtainDatum, null));
                break;
            }
        }
        return $successRespond;
    }

    /**
     * 递归 postman json 获取字段的数据结构
     * @param array $arrDatum
     * @param string|null $keyString
     * @return array
     */
    protected function recursionArr(array $arrDatum, ?string $keyString): array
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

    /**
     * 整理数据成kv
     * @param array $inputArr
     * @return array
     */
    protected function organizeDatum2Kv(array $inputArr): array
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
}