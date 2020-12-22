<?php


namespace Pis0sion\Docx\entity;

use Closure;
use PhpOffice\PhpWord\Element\Section;

/**
 * Class ExportEntity
 * @package Pis0sion\Docx\entity
 */
class ExportEntity
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
        $this->addCategoriesTitle("接入导入", 1);
        $this->addCategoriesTitle("如何快速导入", 2, function ($section) {
            /** @var Section $section */
            $section->addListItem('获取 DEMO 压缩包：', 0, null, "access");
            $section->addListItem('将请求地址改为测试环境请求地址；', 0, null, 'access');
            $section->addListItem('目前仅有 PHP 范例；', 0, null, 'access');
            $section->addListItem('将范例部署到您的应用服务器，并运行；', 0, null, 'access');
            $section->addListItem('在测试环境上请调通接口；', 0, null, 'access');
            $section->addListItem('请求和响应都调通后，便可在范例中加入您系统本身的业务逻辑，并再次在测试环境进行调试，直至通过；', 0, null, 'access');
            $section->addListItem('将您正式的密钥配置到程序中，并将请求地址改为正式环境请求地址后便可上线。', 0, null, 'access');
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("签名无效的解决方案", 2, function ($section) {
            /** @var Section $section */
            $section->addText("解决方法：", null, ['indentation' => ['firstLine' => 480]]);
            $section->addText("首先检查配置中的密钥是否与系统上提供的密钥一致,是否有中文。", null, ['indentation' => ['firstLine' => 480]]);
            $section->addText("其次处理中文转码问题,有两个需要正确转码的环节：", null, ['indentation' => ['firstLine' => 480]]);
            $section->addListItem('涉及中文的参数在传入生成sign的方法时，不能是乱码。', 0, null, 'resolve');
            $section->addListItem('生成请求参数后，涉及中文的参数的值不能是乱码，当前仅支持UTF-8的编码格式。', 0, null, 'resolve');
            $section->addPageBreak();
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