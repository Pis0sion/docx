<?php


namespace Pis0sion\Docx\servlet;

use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\SimpleType\Jc;

/**
 * Class CoverServlet
 * @package Pis0sion\Docx\servlet
 */
class CoverServlet
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * CoverServlet constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * 制作封面
     */
    public function createCover()
    {
        $header = $this->section->addHeader();
        $header->firstPage();

        $textBox = $this->section->addTextBox([
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'width' => 450,
            'height' => 400,
            'borderSize' => 1,
            'borderColor' => '#FF0000',
        ]);

        $textBox->addText('Text box content in section.');
        $textBox->addText('Another line.');

        Html::addHtml($textBox, "<div style='height: 100px;width: 100px; font-size: larger; color: crimson'>fdsfsafsfsafsafdsfasafdsafas</div>", false, false);
        $this->section->addPageBreak();
    }
}