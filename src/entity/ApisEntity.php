<?php


namespace Pis0sion\Docx\entity;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Html;
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
     * @return mixed|void
     */
    public function run()
    {
        $this->addCategoriesTitle("接口列表", 1);
        $this->addCategoriesTitle("用户模块列表", 2);
        for ($i = 100; $i--;) {
            $this->addCategoriesTitle("获取用户信息接口", 3, function ($section) {
                /** @var Section $section */

                $this->renderText($section, "接口地址：http://www.gaoqiaoxue.com/user");
                $this->renderText($section, "返回格式：JSON");
                $this->renderText($section, "请求方式：HTTP/GET");
                $this->renderText($section, "接口备注：的方法滴滴答答滴滴答答滴滴答答滴滴答答顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶顶");
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
                    '参数' => 1500,
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
                $this->renderRawPrettyJson($section, ['name' => 'pis0sion', 'age' => 12, 'user' => ['id' => 5, 'nick_name' => 'gaoqiaoxue']]);
                $section->addTextBreak(1);
                $section->addTextBreak(1);
            });
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
     * @param array $prettyDatum
     */
    protected function renderRawPrettyJson(Section $section, array $prettyDatum)
    {
        $TableCell = $section->addTable([
            'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
            'cellMargin' => 50,
            'alignment' => 'center'
        ]);
        $TableCell->addRow(500);
        $cell = $TableCell->addCell(8000, [
            'valign' => 'center',
            'bgColor' => '4BACC6',
        ]);
        $textRun = $cell->addTextRun(['lineHeight' => 1.5]);
        $result = json_encode($prettyDatum, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $result = "<div style='font-size: 12px;color: black;background: aqua'>" . nl2br($result) . "</div>";
        Html::addHtml($textRun, $result, false, false);
    }

}