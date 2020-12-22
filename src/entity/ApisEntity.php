<?php


namespace Pis0sion\Docx\entity;

use PhpOffice\PhpWord\Element\Section;
use Pis0sion\Docx\layer\AbsBaseEntity;

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
        $this->addCategoriesTitle("接口列表", 1, function ($section) {
            /** @var Section $section */
            $section->addListItem('在未特别注明的情况下，所有的接口均可采用HTTP的POST提交方式发起请求，采用Application/json提交方式提交数据。', 0, null, 'description');
            $section->addListItem('所有接口全部采用HTTPS请求方式。', 0, null, 'description');
            $section->addListItem('数据返回格式为JSON串。', 0, null, 'description');
            $section->addTextBreak(1);
            $section->addTextBreak(1);
        });
    }
}