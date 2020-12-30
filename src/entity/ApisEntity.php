<?php


namespace Pis0sion\Docx\entity;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Table;
use Pis0sion\Docx\layer\AbsBaseEntity;
use Pis0sion\Docx\servlet\TableServlet;

/**
 * Class ApisEntity
 * @package Pis0sion\Docx\entity
 */
class ApisEntity extends AbsBaseEntity
{
    /**
     * @var int
     */
    public $priority = 4;

    /**
     * 生成api接口
     * @param array|null $params
     * @return mixed|void
     */
    public function run(?array $params)
    {
        $this->addCategoriesTitle("接口列表", 1);

        $apis = $params['apis'] ?? [];
        foreach ($apis as $apiModule) {
            $this->addCategoriesTitle($apiModule['module_name'], 2);
            foreach ($apiModule['module_list'] as $apiList) {
                $this->addCategoriesTitle($apiList['name'], 3, function ($section) use ($apiList) {
                    /** @var Section $section */
                    $this->renderText($section, "接口地址：", $apiList['request']['api_url']);
                    $this->renderText($section, "返回格式：", $apiList['request']['contentType']);
                    $this->renderText($section, "请求方式：", strtolower($apiList['request']['method']));
                    $this->renderText($section, "接口备注：", $apiList['request']['description']);
                    $this->renderText($section, "调试工具：", "postman");
                    $section->addTextBreak();
                    $this->renderText($section, "请求参数说明：");
                    $requestParameters = $apiList['request']['parameters'];
                    if (count($requestParameters) == true) {
                        (new TableServlet($section))->run([
                            '参数名称' => 2000,
                            '示例值' => 1800,
                            '类型' => 1200,
                            '参数说明' => 3000,
                        ], $requestParameters);
                    } else {
                        (new TableServlet($section))->runEmptyForm([
                            '参数名称' => 2000,
                            '示例值' => 1800,
                            '类型' => 1200,
                            '参数说明' => 3000,
                        ], "无请求参数 KEY/VALUE 类型");
                    }
                    $section->addTextBreak();
                    if (!empty($apiList['request']['raws'])) {
                        $this->renderText($section, "请求示例：");
                        $this->renderRawPrettyJson($section, $apiList['request']['raws'], '4b5661', '#2eff5e');
                        $section->addTextBreak();
                    }
                    $responseBody = $apiList['response']['body'];
                    $this->renderText($section, "返回参数说明：");
                    if (count($responseBody) == true) {
                        (new TableServlet($section))->run([
                            '参数名称' => 2000,
                            '示例值' => 1800,
                            '类型' => 1200,
                            '参数说明' => 3000,
                        ], $responseBody);
                    } else {
                        (new TableServlet($section))->runEmptyForm([
                            '参数名称' => 2000,
                            '示例值' => 1800,
                            '类型' => 1200,
                            '参数说明' => 3000,
                        ], "无响应参数 KEY/VALUE 类型");
                    }
                    $section->addTextBreak();
                    // 响应结果如果是文件
                    // 暂时不做处理
                    $this->renderText($section, "返回示例：");
                    $this->renderRawPrettyJson($section, $apiList['response']['raw']);
                    $section->addTextBreak();
                    $section->addTextBreak();
                });
            }
        }
    }

    /**
     * @param Section $section
     * @param string $apiType
     * @param string $text
     */
    protected function renderText(Section $section, string $apiType, string $text = '')
    {
        $textRun = $section->addTextRun(['indentation' => ['left' => 480]]);
        $textRun->addText($apiType);
        if (!empty($text)) {
            $textRun->addText($text, ['italic' => true]);
        }
    }

    /**
     * 渲染 Raw
     * @param Section $section
     * @param string|null $prettyDatum
     * @param string $bgColor
     * @param string $fontColor
     */
    protected function renderRawPrettyJson(Section $section, ?string $prettyDatum, string $bgColor = 'DDEDFB', string $fontColor = 'black')
    {
        $TableCell = $section->addTable([
            'layout' => Table::LAYOUT_FIXED,
            'cellMargin' => 50,
            'alignment' => 'center'
        ]);
        $TableCell->addRow(500);
        $cell = $TableCell->addCell(8000, [
            'valign' => 'center',
            'bgColor' => $bgColor,
        ]);
        //$textRun = $cell->addTextRun(['lineHeight' => 1.2]);
        // 转化为p标签
        $prettyString = $this->prettyStringJson($prettyDatum);
        $result = "<div style='font-size: 13px;color: {$fontColor};'>" . $prettyString . "</div>";
        Html::addHtml($cell, $result, false, false);
    }

    /**
     * 美化json字符串
     * @param string $prettyJson
     * @return string
     */
    protected function prettyStringJson(string $prettyJson): string
    {
        $prettyString = "";
        $token = strtok($prettyJson, "\r\n");
        while ($token != false) {
            $prettyString .= "<p>$token</p>";
            $token = strtok("\r\n");
        }
        return $prettyString;
    }
}