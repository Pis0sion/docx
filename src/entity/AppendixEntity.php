<?php


namespace Pis0sion\Docx\entity;

use Closure;
use PhpOffice\PhpWord\Element\Section;

/**
 * Class AppendixEntity
 * @package Pis0sion\Docx\entity
 */
class AppendixEntity
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * IntroductionEntity constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    public function run()
    {
        $this->addCategoriesTitle("附录", 1);
        $this->addCategoriesTitle("返回码列表", 2, function ($section) {
            $appendix = [
                [
                    'param' => "SYS_API_0000",
                    'namely' => "成功！",
                ],
                [
                    'param' => "SYS_API_999",
                    'namely' => "注册参数校验失败/抱歉,白名单参数有误！/ 抱歉,冻结天数超出范围！/ 传入的参数有误！",
                ],
                [
                    'param' => "SYS_API_998",
                    'namely' => "调用接口失败。",
                ],
                [
                    'param' => "SYS_API_997",
                    'namely' => "附件大小不符合规范。",
                ],
                [
                    'param' => "",
                    'namely' => "",
                ],
                [
                    'param' => "",
                    'namely' => "",
                ],
                [
                    'param' => "",
                    'namely' => "",
                ],
                [
                    'param' => "",
                    'namely' => "",
                ],
            ];
            (new CommonTableEntity($section))->run([
                '返回码' => 2000,
                '说明' => 7000,
            ], $appendix);
            $section->addTextBreak(1);
        });
    }

    /**
     * 设置分类主题的目录
     * @param string $titleName
     * @param int $depth
     * @param Closure|null $render
     */
    protected function addCategoriesTitle(string $titleName, int $depth, Closure $render = null)
    {
        $this->section->addTitle($titleName, $depth);       // 添加主题，并且写入目录
        $this->section->addTextBreak(1);
        ($render instanceof Closure) && $render($this->section);
    }
}