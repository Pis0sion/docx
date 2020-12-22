<?php


namespace Pis0sion\Docx\entity;

use Closure;
use PhpOffice\PhpWord\Element\Section;

/**
 * Class ManualEntity
 * @package Pis0sion\Docx\entity
 */
class ManualEntity
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * ManualEntity constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * 创建使用流程
     */
    public function createManual()
    {
        $this->addCategoriesTitle("使用流程", 1, function ($section) {
            /** @var Section $section */
            $section->addListItem('准备阶段：', 0, null, "manual");
            $section->addListItem('申请测试号等信息；', 1, null, 'manual');
            $section->addListItem('取得开发手册（本文档）等资料；', 1, null, 'manual');
            $section->addListItem('开发阶段：', 0, null, 'manual');
            $section->addListItem('根据提供的 DEMO 结合开发文档快速熟悉对接接口；', 1, null, 'manual');
            $section->addListItem('根据本系统提供的接口，在商户自己的系统上进行开发，实现所需要的业务功能；', 1, null, 'manual');
            $section->addListItem('对自己系统的业务功能进行全面测试；', 1, null, 'manual');
            $section->addListItem('与测试环境进行联调。', 1, null, 'manual');
            $section->addListItem('生产使用：', 0, null, 'manual');
            $section->addListItem('使用系统提供的正式资料。', 1, null, 'manual');
            $section->addTextBreak(1);
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