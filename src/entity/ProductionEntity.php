<?php


namespace Pis0sion\Docx\entity;

use Closure;
use PhpOffice\PhpWord\Element\Section;

/**
 * Class ProductionEntity
 * @package Pis0sion\Docx\entity
 */
class ProductionEntity
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * DescriptionEntity constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    public function run()
    {
        $this->addCategoriesTitle("生产环境资料", 1);
        $this->addCategoriesTitle("如何获取服务器地址", 2, function ($section) {
            /** @var Section $section */
            $section->addText("以阿里云为例，登录阿里云后台找到 ECS 控制台，找到公网地址，复制保存即可。", null, ['indentation' => ['firstLine' => 480]]);
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("如何获取公钥和私钥", 2, function ($section) {
            /** @var Section $section */
            $section->addText("登录系统服务商的后台，或者联系相关的技术指导人员进行获取。", null, ['indentation' => ['firstLine' => 480]]);
            $section->addText("（关于密钥的保管：贵公司一定要保证密钥仅能被少数可靠的授权人知晓，严防密钥被不可信的人获取，如密钥泄露需立即进行修改同时替换程序中的密钥。）", ['color' => 'ff0000'], ['indentation' => ['firstLine' => 480]]);
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