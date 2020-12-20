<?php

require "./vendor/autoload.php";

$phpWordServlet = new \Pis0sion\Docx\servlet\PhpWordServlet();

// 初始化
$phpWordServlet->init();

// 创建 section
// 设置边框大小颜色
$section = $phpWordServlet->newSection(['borderColor' => '161616', 'borderSize' => 6]);

//