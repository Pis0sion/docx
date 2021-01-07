<?php


namespace Pis0sion\Docx\factory;

use Inhere\Console\Exception\ConsoleException;
use Pis0sion\Docx\Core;
use Pis0sion\Docx\servlet\CoverServlet;
use Pis0sion\Docx\servlet\FooterServlet;
use Pis0sion\Docx\servlet\HeaderServlet;
use Pis0sion\Docx\servlet\PhpWordServlet;
use Pis0sion\Docx\servlet\TableServlet;
use Pis0sion\Docx\servlet\TocServlet;
use Throwable;

/**
 * Class CreateDocxFactory
 * @package Pis0sion\Docx\factory
 */
class CreateDocxFactory
{
    /**
     * @param string $inputJson
     * @param string $outDocx
     * @param string $apiTools
     * @return array
     */
    public function run(string $inputJson, string $outDocx, string $apiTools): array
    {
        $errCode = '1000';
        $errMessage = '转换成功';
        try {
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
            // 失败抛异常
            try {
                $apis = (new ConvertorFactory())->createConvertor($apiTools)->parse2RenderDocx($convertJson);
            } catch (Throwable $throwable) {
                throw new ConsoleException($throwable->getMessage());
            }
            // 生成文档
            (new Core())->run($section, compact("apis"));
            // 保存文件
            $phpWordServlet->saveAs($outDocx);
        } catch (Throwable $throwable) {
            $errMessage = $throwable->getMessage();
        }

        return compact('errCode', 'errMessage');
    }
}