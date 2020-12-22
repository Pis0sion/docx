<?php

use Pis0sion\Docx\entity\ApisEntity;
use Pis0sion\Docx\entity\AppendixEntity;
use Pis0sion\Docx\entity\CommonTableEntity;
use Pis0sion\Docx\entity\DescriptionEntity;
use Pis0sion\Docx\entity\ExportEntity;
use Pis0sion\Docx\entity\IntroductionEntity;
use Pis0sion\Docx\entity\ManualEntity;
use Pis0sion\Docx\entity\ProductionEntity;
use Pis0sion\Docx\servlet\FooterServlet;
use Pis0sion\Docx\servlet\HeaderServlet;
use Pis0sion\Docx\servlet\PhpWordServlet;
use Pis0sion\Docx\servlet\TocServlet;

require "./vendor/autoload.php";

// 实例化 PhpWord 对象
$phpWordServlet = new PhpWordServlet();
// 初始化
$phpWordServlet->init();

// 创建页面
// 设置页面边框大小颜色
$section = $phpWordServlet->newSection(['borderColor' => '161616', 'borderSize' => 6]);
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
(new CommonTableEntity($section))->run([
    '日期' => 1800,
    '版本' => 1500,
    '说明' => 4000,
    '作者' => 1500,
], $version);
$section->addPageBreak();

// 创建目录
(new TocServlet($section))->setTOC();

// 创建文章简介
// 简介 Introduction
(new IntroductionEntity($section))->run();

// 创建使用流程
// 使用 Manual
(new ManualEntity($section))->run();

// 创建接口说明
// 说明 Description
(new DescriptionEntity($section))->run();

// 创建接口列表
(new ApisEntity($section))->run();

// 生产环境资料
// 生产 production
(new ProductionEntity($section))->run();

// 接入导入
// 导入 export
(new ExportEntity($section))->run();

// 附录
// appendix
(new AppendixEntity($section))->run();

// 保存文件
$phpWordServlet->saveAs("./pis0sion.docx");