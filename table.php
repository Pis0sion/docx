<?php


use PhpOffice\PhpWord\Element\Table;

class TableService
{
    /**
     * @var array
     */
    protected $styleTable;

    /**
     * @var array
     */
    protected $styleFirstRow;

    /**
     * TableService constructor.
     */
    public function __construct()
    {
        $this->styleTable = [
            'borderColor' => 'ECCFEA',
            'borderSize' => 6,
            'cellMargin' => 50,
            'align' => 'center'
        ];

        $this->styleFirstRow = [
            'bgColor' => '709BCA'
        ];
    }


    /**
     * @return array
     */
    public function getStyleTable(): array
    {
        return $this->styleTable;
    }

    /**
     * @param array $styleTable
     */
    public function setStyleTable(array $styleTable): void
    {
        $this->styleTable = $styleTable;
    }

    /**
     * @return array
     */
    public function getStyleFirstRow(): array
    {
        return $this->styleFirstRow;
    }

    /**
     * @param array $styleFirstRow
     */
    public function setStyleFirstRow(array $styleFirstRow): void
    {
        $this->styleFirstRow = $styleFirstRow;
    }

    /**
     * @param $section
     * @param $renderDatum
     */
    public function drawSpecificTable($section, $renderDatum)
    {

        /** @var Table $table */
        $table = $section->addTable('myTable');

        $table->addRow(null);
        $table->addCell(2000, ['valign' => 'center'])->addText('参数', ['size' => '10.5'], ['align' => 'center']);
        $table->addCell(2000, ['valign' => 'center'])->addText('示例值', ['size' => '10.5'], ['align' => 'center']);
        $table->addCell(2000, ['valign' => 'center'])->addText('必填', ['size' => '10.5'], ['align' => 'center']);
        $table->addCell(2000, ['valign' => 'center'])->addText('参数描述', ['size' => '10.5'], ['align' => 'center']);

        foreach ($renderDatum as $datum) {
            $table->addRow(500);
            $table->addCell(2000, ['valign' => 'center'])->addText($datum['param'], null, ['align' => 'center']);
            $table->addCell(2000, ['valign' => 'center'])->addText($datum['namely'], null, ['align' => 'center']);
            $table->addCell(2000, ['valign' => 'center'])->addText($datum['isBool'], null, ['align' => 'center']);
            $table->addCell(2000, ['valign' => 'center'])->addText($datum['desc'], null, ['align' => 'center']);
        }
    }
}

