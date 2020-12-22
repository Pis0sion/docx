<?php


namespace Pis0sion\Docx\entity;

use Closure;
use PhpOffice\PhpWord\Element\Section;

/**
 * Class ApisEntity
 * @package Pis0sion\Docx\entity
 */
class ApisEntity
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * ApisEntity constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    public function run()
    {
        $this->addCategoriesTitle("接口列表", 1, function ($section) {
            /** @var Section $section */
            $section->addListItem('在未特别注明的情况下，所有的接口均可采用HTTP的POST提交方式发起请求，采用Application/json提交方式提交数据。', 0, null, 'description');
            $section->addListItem('所有接口全部采用HTTPS请求方式。', 0, null, 'description');
            $section->addListItem('数据返回格式为JSON串。', 0, null, 'description');
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