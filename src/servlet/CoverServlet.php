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

        $this->section->addPageBreak();
    }
}