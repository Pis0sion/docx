<?php


namespace Pis0sion\Docx\servlet;

use PhpOffice\PhpWord\Element\Section;
use Pis0sion\Docx\component\TablesGenerator;

/**
 * Class TableServlet
 * @package Pis0sion\Docx\servlet
 */
class TableServlet
{
    /**
     * @var Section
     */
    protected $section;

    /**
     * CommonTableEntity constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * @return TablesGenerator
     */
    public function generation(): TablesGenerator
    {
        return (new TablesGenerator($this->section))->setFirstCellStyle([
            'valign' => 'center',
            'bgColor' => 'D8D8D8',
        ])
            ->setHeaderFStyle([
                'size' => '11',
                'bold' => true
            ])->setHeaderPStyle([
                'align' => 'center',
                'lineHeight' => 1,
            ])->setCellStyle([
                'valign' => 'center'
            ])
            ->setFStyle([
                'size' => '10.5'
            ])->setPStyle([
                'align' => 'center',
                'lineHeight' => 1,
            ])->setExactHeight(false);
    }

    /**
     * 生成普通表格
     * @param array $obstruction
     * @param array $render
     */
    public function run(array $obstruction, array $render)
    {
        return $this->generation()->generateTable($obstruction, $render);
    }

    /**
     * 生成空表格
     * @param array $obstruction
     * @param string $renderDatum
     */
    public function runEmptyForm(array $obstruction, string $renderDatum)
    {
        return $this->generation()->generateUnresponsiveTable($obstruction, $renderDatum);
    }


}