<?php


namespace Pis0sion\Docx\servlet;

use PhpOffice\PhpWord\Element\Section;

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
        $coverTable = $this->section->addTable();
        $coverRow = $coverTable->addRow(6000);
        $coverRow->addCell(10000, ['valign' => 'center'])->addText("项目接口文档", ['size' => 32, 'color' => 'black'], ['align' => 'center']);;
        $this->section->addTextBreak(15);
        $coverAuthor = $this->section->addTable();
        $AuthorRow = $coverAuthor->addRow(400);
        $AuthorRow->addCell(10000, ['valign' => 'center'])->addText("某某网络有限公司", ['size' => 12, 'color' => '4F81BD'], ['align' => 'right']);
        $TimeRow = $coverAuthor->addRow(400);
        $TimeRow->addCell(10000, ['valign' => 'center'])->addText("2020/12/30", ['size' => 12, 'color' => '4F81BD'], ['align' => 'right']);
    }
}