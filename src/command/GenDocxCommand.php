<?php


namespace Pis0sion\Docx\command;


use Inhere\Console\Command;
use Inhere\Console\Exception\ConsoleException;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Pis0sion\Docx\categories\postman\ApisPostManParser;
use Pis0sion\Docx\Core;
use Pis0sion\Docx\servlet\FooterServlet;
use Pis0sion\Docx\servlet\HeaderServlet;
use Pis0sion\Docx\servlet\PhpWordServlet;
use Pis0sion\Docx\servlet\TableServlet;
use Pis0sion\Docx\servlet\TocServlet;

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
            ->addOption('tools', null, Input::OPT_REQUIRED, 'description for the option [tools], is required');
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
        $apiTools = $input->getOpt('tools');

        if (trim($apiTools) != 'postman') {
            throw new ConsoleException('not support api tools');
        }

        // 实例化 PhpWord 对象
        $phpWordServlet = new PhpWordServlet();
        // 初始化
        $phpWordServlet->init();
        // 创建封面
        $cover = $phpWordServlet->newSection();

        // 创建页面
        // 设置页面边框大小颜色
        $section = $phpWordServlet->newSection(['borderColor' => '161616', 'borderSize' => 6]);
        //$header = $section->addHeader();
        //$header->firstPage();
        // 创建页眉页脚
        (new HeaderServlet($section->addHeader()))->setHeader();
        (new FooterServlet($section->addFooter()))->setFooter();

        // 版本内容
        $version = [
            [
                'param' => "2020/4/8",
                'namely' => "V0.0.1",
                'isBool' => "新增文档",
                'desc' => "老詹",
            ],
            [
                'param' => "2020/4/10",
                'namely' => "V0.0.2",
                'isBool' => "格式调整及描述修改",
                'desc' => "小张",
            ],
            [
                'param' => "2020/5/8",
                'namely' => "V1.0.0",
                'isBool' => "新增鉴权",
                'desc' => "小张、老詹",
            ],
            [
                'param' => "2020/5/11",
                'namely' => "V1.0.1",
                'isBool' => "修改鉴权",
                'desc' => "小张、老詹",
            ],
            [
                'param' => "",
                'namely' => "",
                'isBool' => "",
                'desc' => "",
            ],
            [
                'param' => "",
                'namely' => "",
                'isBool' => "",
                'desc' => "",
            ],
            [
                'param' => "",
                'namely' => "",
                'isBool' => "",
                'desc' => "",
            ],
            [
                'param' => "",
                'namely' => "",
                'isBool' => "",
                'desc' => "",
            ],
        ];
        (new TableServlet($section))->run([
            '日期' => 1800,
            '版本' => 1500,
            '说明' => 4000,
            '作者' => 1500,
        ], $version);
        $section->addPageBreak();

        // 创建目录
        (new TocServlet($section))->setTOC();

        // 获取json数据
        $postmanJson = file_get_contents($inputJson);
        $projectVars = (new ApisPostManParser())->parse2RenderDocx($postmanJson);

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