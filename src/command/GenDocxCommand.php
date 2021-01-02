<?php


namespace Pis0sion\Docx\command;


use Inhere\Console\Command;
use Inhere\Console\Exception\ConsoleException;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Pis0sion\Docx\Core;
use Pis0sion\Docx\factory\ConvertorFactory;
use Pis0sion\Docx\servlet\CoverServlet;
use Pis0sion\Docx\servlet\FooterServlet;
use Pis0sion\Docx\servlet\HeaderServlet;
use Pis0sion\Docx\servlet\PhpWordServlet;
use Pis0sion\Docx\servlet\TableServlet;
use Pis0sion\Docx\servlet\TocServlet;
use Throwable;

/**
 * Class GenDocxCommand
 * @package Pis0sion\Docx\command
 */
class GenDocxCommand extends Command
{

    /**
     * @var string
     */
    protected static $name = 'gen';

    /**
     * @var string
     */
    protected static $description = 'postman convert docx';

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->createDefinition()
            ->setExample($this->parseCommentsVars('{script} {command} postman.json postman.docx --tools postman'))
            ->addArgument('inputJson', Input::ARG_REQUIRED, 'description for the argument [inputJson], is optional')
            ->addArgument('outDocx', Input::ARG_REQUIRED, 'description for the argument [outDocx], is optional')
            ->addOption('tools', null, Input::OPT_OPTIONAL, 'description for the option [tools], is required');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int|mixed
     */
    protected function execute($input, $output)
    {
        // TODO: Implement execute() method.
        $inputJson = $input->getArg('inputJson');
        $outDocx = $input->getArg('outDocx');
        // 默认postman
        $apiTools = trim($input->getOpt('tools', 'postman'));
        // 实例化 PhpWord 对象
        $phpWordServlet = new PhpWordServlet();
        // 初始化
        $phpWordServlet->init();
        // 创建封面
        $cover = $phpWordServlet->newSection();
        (new CoverServlet($cover))->createCover();
        // 创建页面
        // 设置页面边框大小颜色
        $section = $phpWordServlet->newSection(['borderColor' => '161616', 'borderSize' => 6]);
        // 创建页眉页脚
        (new HeaderServlet($section->addHeader()))->setHeader();
        (new FooterServlet($section->addFooter()))->setFooter();

        // 版本内容
        (new TableServlet($section))->run(VersionFormatter, ProjectVersion);
        $section->addPageBreak();
        // 创建目录
        (new TocServlet($section))->setTOC();
        // 获取json数据
        $convertJson = file_get_contents($inputJson);
        // 抛异常
        try {
            $projectVars = (new ConvertorFactory())->createConvertor($apiTools)->parse2RenderDocx($convertJson);
        } catch (Throwable $throwable) {
            throw new ConsoleException($throwable->getMessage());
        }

        $apis = [
            "apis" => $projectVars,
        ];
        // 生成文档
        (new Core())->run($section, $apis);
        // 保存文件
        $phpWordServlet->saveAs($outDocx);

        $output->write("generate docx successful");
        return 0;
    }
}