<?php


namespace Pis0sion\Docx\entity;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Html;
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
                    $this->renderText($section, "接口地址：{$apiList['request']['api_url']}");
                    $this->renderText($section, "返回格式：{$apiList['request']['contentType']}");
                    $this->renderText($section, "请求方式：{$apiList['request']['method']}");
                    $this->renderText($section, "接口备注：{$apiList['request']['description']}");
                    $this->renderText($section, "调试工具：POSTMAN");

                    $section->addTextBreak();
                    $this->renderText($section, "请求参数说明：");
                    $render = [
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                    ];
                    (new TableServlet($section))->run([
                        '参数名称' => 1500,
                        '示例值' => 1800,
                        '必填' => 1200,
                        '参数说明' => 3500,
                    ], $render);
                    $section->addTextBreak();
                    $this->renderText($section, "返回参数说明：");
                    $render = [
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                        [
                            'param' => "name",
                            'namely' => "你好",
                            'isBool' => "必填",
                            'desc' => "等方式尽快发货大",
                        ],
                    ];
                    (new TableServlet($section))->run([
                        '参数' => 1500,
                        '示例值' => 1800,
                        '必填' => 1200,
                        '参数说明' => 3500,
                    ], $render);
                    $section->addTextBreak(1);
                    $this->renderText($section, "返回示例：");
                    $this->renderRawPrettyJson($section, $apiList['response'][0]['body']);
                    $section->addTextBreak(1);
                    $section->addTextBreak(1);
                });
            }
        }
    }

    /**
     * @param Section $section
     * @param string $text
     */
    protected function renderText(Section $section, string $text)
    {
        $section->addText($text, null, ['indentation' => ['left' => 480]]);
    }

    /**
     * 渲染 Raw
     * @param Section $section
     * @param string|null $prettyDatum
     */
    protected function renderRawPrettyJson(Section $section, ?string $prettyDatum)
    {
        $TableCell = $section->addTable([
            'layout' => Table::LAYOUT_FIXED,
            'cellMargin' => 50,
            'alignment' => 'center'
        ]);
        $TableCell->addRow(500);
        $cell = $TableCell->addCell(8000, [
            'valign' => 'center',
            'bgColor' => 'DDEDFB',
        ]);
        $textRun = $cell->addTextRun(['lineHeight' => 1.5]);
        $result = "<div style='font-size: 12px;color: black;'>" . nl2br($prettyDatum) . "</div>";
        Html::addHtml($textRun, $result, false, false);
    }

}