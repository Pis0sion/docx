<?php

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

require "./vendor/autoload.php";


$phpWord = new PhpWord();
$section = $phpWord->addSection();

// Add first page header
$header = $section->addHeader();
$header->firstPage();
$table = $header->addTable();
$table->addRow();
$cell = $table->addCell(4500);
$textrun = $cell->addTextRun();
$textrun->addText('This is the header with ');
$textrun->addLink('https://github.com/PHPOffice/PHPWord', 'PHPWord on GitHub');
$table->addCell(4500)->addImage('resources/mars.jpg', array('width' => 800, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

// Add header for all other pages
$subsequent = $section->addHeader();
//$subsequent->addText('Subsequent pages in Section 1 will Have this!');
$subsequent->addImage('resources/left.png', array('width' => 100, 'height' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
$wrappingStyles = array('inline', 'behind', 'infront', 'square', 'tight');
$subsequent->addImage('resources/right.png',     array(
    'positioning'        => 'relative',
    'marginTop'          => -1,
    'marginLeft'         => 1,
    'width'              => 80,
    'height'             => 80,
    'wrappingStyle'      => "behind",
    'wrapDistanceRight'  => Converter::cmToPoint(1),
    'wrapDistanceBottom' => Converter::cmToPoint(1),
));

// Add footer
$footer = $section->addFooter();
$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$footer->addLink('https://github.com/PHPOffice/PHPWord', 'PHPWord on GitHub');

// Write some text
$section->addTextBreak();
$section->addText('Some text...');

// Create a second page
$section->addPageBreak();

// Write some text
$section->addTextBreak();
$section->addText('Some text...');

// Create a third page
$section->addPageBreak();

// Write some text
$section->addTextBreak();
$section->addText('Some text...');

// New portrait section
$section2 = $phpWord->addSection();

$sec2Header = $section2->addHeader();
$sec2Header->addText('All pages in Section 2 will Have this!');

// Write some text
$section2->addTextBreak();
$section2->addText('Some text...');

$filename = time() . uniqid() . ".docx";
$phpWord->save($filename);