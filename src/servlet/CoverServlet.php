<?php


namespace Pis0sion\Docx\servlet;

use PhpOffice\PhpWord\Element\Section;
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

        $projectBox = $this->section->addTextBox(
            array(
                'alignment' => Jc::CENTER,
                'width' => 400,
                'height' => 350,
                'borderColor' => '#FFFFFF',
                'valign' => 'center',
            )
        );
        $projectBox->addTextBreak(8);
        $projectBox->addText('项目接口文档', ['size' => 32, 'color' => 'black'], ['align' => 'center']);

        $this->section->addTextBreak();

        $authorBox = $this->section->addTextBox(
            array(
                'alignment' => Jc::CENTER,
                'width' => 400,
                'height' => 250,
                'borderColor' => '#FFFFFF',
                'valign' => 'center',
            )
        );

        $authorBox->addTextBreak(8);
        $authorBox->addText("某某网络有限公司", ['size' => 12, 'color' => '4F81BD'], ['align' => 'right']);
        $authorBox->addText("2020/12/30", ['size' => 12, 'color' => '4F81BD'], ['align' => 'right']);
    }
}