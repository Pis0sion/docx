<?php


namespace Pis0sion\Docx;

use PhpOffice\PhpWord\Element\Section;
use Pis0sion\Docx\entity\ApisEntity;
use Pis0sion\Docx\entity\AppendixEntity;
use Pis0sion\Docx\entity\DescriptionEntity;
use Pis0sion\Docx\entity\ExportEntity;
use Pis0sion\Docx\entity\IntroductionEntity;
use Pis0sion\Docx\entity\ManualEntity;
use Pis0sion\Docx\entity\ProductionEntity;
use Pis0sion\Docx\layer\IEntityInterface;
use SplObjectStorage;

/**
 * Class Core
 * @package Pis0sion\Docx
 */
class Core
{
    /**
     * @var SplObjectStorage
     */
    protected $objectStorage;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        $this->objectStorage = new \SplQueue();
    }

    /**
     * 初始化模块
     * @param Section $section
     */
    protected function initialize(Section $section)
    {
        $introduction = new IntroductionEntity($section);
        $this->appendObject2Queue($introduction);
        $manual = new ManualEntity($section);
        $this->appendObject2Queue($manual);
        $description = new DescriptionEntity($section);
        $this->appendObject2Queue($description);
        $apis = new ApisEntity($section);
        $this->appendObject2Queue($apis);
        $production = new ProductionEntity($section);
        $this->appendObject2Queue($production);
        $export = new ExportEntity($section);
        $this->appendObject2Queue($export);
        $appendix = new AppendixEntity($section);
        $this->appendObject2Queue($appendix);
    }

    /**
     * 运行
     * @param Section $section
     */
    public function run(Section $section)
    {
        $this->initialize($section);
        while (!$this->objectStorage->isEmpty()) {
            $this->objectStorage->dequeue()->run();
        }
    }

    /**
     * @param IEntityInterface $IEntity
     */
    protected function appendObject2Queue(IEntityInterface $IEntity)
    {
        $this->objectStorage->enqueue($IEntity);
    }
}