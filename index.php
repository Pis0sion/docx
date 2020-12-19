<?php

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\DocProtect;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\TOC;
use Pis0sion\Docx\component\TableGenerator;

require "./vendor/autoload.php";

// XML Writer兼容性 默认为 true  开发建议 false
Settings::setCompatibility(false);
// 输出转义
Settings::setOutputEscapingEnabled(true);

$phpWord = new PhpWord();
//
$documentProtection = $phpWord->getSettings()->getDocumentProtection();
$documentProtection->setEditing(DocProtect::READ_ONLY);

$properties = $phpWord->getDocInfo();
$properties->setCreator('Gaoqiaoxue');
$properties->setCompany('Gaoqiaoxue');
$properties->setTitle('Api document');
$properties->setDescription('My description');
$properties->setCategory('My category');
$properties->setLastModifiedBy('Gaoqiaoxue');
$properties->setCreated(mktime(0, 0, 0, 12, 19, 2020));
$properties->setModified(mktime(0, 0, 0, 12, 19, 2020));
$properties->setSubject('My subject');
$properties->setKeywords('my, key, word');

// 强制更新字段 关闭
$phpWord->getSettings()->setUpdateFields(true);
// 拼写和语法检查
$phpWord->getSettings()->setHideGrammaticalErrors(true);
$phpWord->getSettings()->setHideSpellingErrors(true);

$phpWord->setDefaultFontSize(11);
$phpWord->setDefaultParagraphStyle(['lineHeight' => 1.5, 'size' => 12]);

// 创建一个页面
$section = $phpWord->addSection(['borderColor' => '161616', 'borderSize' => 6]);

$fontStyle12 = array('spacing' => 8, 'lineHeight' => 1.5, 'size' => 12);
$styleToc = ['tabLeader' => TOC::TAB_LEADER_DOT, 'indent' => 100];

$header = $section->addHeader();
$header->firstPage();

// 带有数字的标题
$phpWord->addNumberingStyle(
    'hNum',
    ['type' => 'multilevel', 'levels' => [
        array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1'),
        array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
        array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
    ]]
);

// 设置各类的标题
$phpWord->addTitleStyle(null, array('size' => 20, 'bold' => true, 'spacing' => 8, 'lineHeight' => 1.8));
$phpWord->addTitleStyle(1, array('size' => 18, 'color' => '333333', 'bold' => true, 'lineHeight' => 1), array('numStyle' => 'hNum', 'numLevel' => 0));
$phpWord->addTitleStyle(2, array('size' => 14, 'color' => '333333', 'bold' => true, 'lineHeight' => 1), array('numStyle' => 'hNum', 'numLevel' => 1));
$phpWord->addTitleStyle(3, array('size' => 12, 'color' => '333333', 'lineHeight' => 1), array('numStyle' => 'hNum', 'numLevel' => 2));
$phpWord->addTitleStyle(4, array('size' => 8, 'lineHeight' => 1));

// 添加页眉
$header = $section->addHeader();
$header->addText("Api Document | Pis0sion", ['size' => 8, 'color' => '4f81bd'], ['width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);

//$section->addTitle('版本管理', 0);
$section->addTextBreak(1);
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
$tableVersion = new TableGenerator($section);
$tableVersion->setFirstCellStyle([
    'valign' => 'center',
    'bgColor' => 'D8D8D8',
]);
$tableVersion->setHeaderFStyle([
    'size' => '11',
    'bold' => true
]);
$tableVersion->setHeaderPStyle([
    'align' => 'center',
    'lineHeight' => 1,
]);
$tableVersion->setCellStyle([
    'valign' => 'center'
]);
$tableVersion->setFStyle([
    'size' => '10.5'
]);
$tableVersion->setPStyle([
    'align' => 'center',
    'lineHeight' => 1,
]);
$tableVersion->setExactHeight(false);
$tableVersion->generateTable([
    '日期' => 1800,
    '版本' => 1500,
    '说明' => 4000,
    '作者' => 1500,
], $version);

$footer = $section->addFooter();   // 页眉
$footer->addPreserveText('页 {PAGE}/{NUMPAGES}', null, array('alignment' => Jc::CENTER));
$footer->addLink("http://www.gaoqiaoxue.com", "Pis0sion 制作");
$section->addPageBreak();

// 添加项目目录
$section->addTitle('目录', 0);           // 添加主题，不写入目录中 depth:0
// Add TOC #1
$toc = $section->addTOC($fontStyle12, $styleToc);  // 目录内容字体大小，以及目录内容的行间距
$section->addTextBreak(1);                   // 空两行

$section->addPageBreak();                          // 分页

$section->addTitle('文档简介', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);

$section->addTitle("特别声明", 2);
$section->addTextBreak(1);
$section->addText("未得到本公司的书面许可，不得为任何目的、以任何形式或手段（包括但不限于机械的或电子的）复制或传播本文档的任何部分。对于本文档涉及的技术和产品，本公司拥有其专利（或正在申请专利）、商标、版权或其它知识产权。除非得到本公司的书面许可协议，本文档不授予这些专利、商标、版权或其它知识产权的许可。", null, ['indentation' => ['firstLine' => 480]]);
$section->addText("本文档因产品功能示例和描述的需要，所使用的任何人名、企业名和数据都是虚构的，并仅限于本公司内部测试使用，不等于本公司有对任何第三方的承诺和宣传。", null, ['indentation' => ['firstLine' => 480]]);
$section->addTextBreak(1);

$multilevelNumberingStyleName = 'multilevel';
$phpWord->addNumberingStyle(
    $multilevelNumberingStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);
$section->addTitle("阅读对象", 2);
$section->addTextBreak(1);
$section->addText("贵公司的技术部门的开发、维护及管理人员，应具备以下基本知识：", null, ['indentation' => ['firstLine' => 480]]);
$section->addListItem("了解HTTPS/HTTP协议等内容。", 0, null, $multilevelNumberingStyleName);
$section->addListItem("了解信息安全的基本概念。", 0, null, $multilevelNumberingStyleName);
$section->addListItem("了解计算机至少一种编程语言。", 0, null, $multilevelNumberingStyleName);
$section->addTextBreak(1);

$section->addTitle("产品说明", 2);
$section->addTextBreak(1);
$section->addText("本开发手册对该系统功能接口进行详细的描述，通过该指南可以对本系统有全面的了解，使技术人员尽快掌握本系统的接口，并能够在本系统上进行开发。", null, ['indentation' => ['firstLine' => 480]]);
$section->addTextBreak(1);

$section->addTitle("名词解释", 2);
$section->addTextBreak(1);
$glossary = [
    [
        'param' => "商户",
        'namely' => "本文档中的商户为接入系统商户。",
    ],
    [
        'param' => "商户编号",
        'namely' => "在该系统中唯一的商户标识。",
    ],
    [
        'param' => "模块依赖",
        'namely' => "本系统中模块中的耦合关系。",
    ],
];
$tableVersion = new TableGenerator($section);
$tableVersion->setFirstCellStyle([
    'valign' => 'center',
    'bgColor' => 'D8D8D8',
]);
$tableVersion->setHeaderFStyle([
    'size' => '11',
    'bold' => true
]);
$tableVersion->setHeaderPStyle([
    'align' => 'center',
    'lineHeight' => 1,
]);
$tableVersion->setCellStyle([
    'valign' => 'center'
]);
$tableVersion->setFStyle([
    'size' => '10.5'
]);
$tableVersion->setPStyle([
    'align' => 'center',
    'lineHeight' => 1,
]);
$tableVersion->setExactHeight(false);
$tableVersion->generateTable([
    '名词缩写' => 2500,
    '名词定义' => 5500,
], $glossary);

$section->addTextBreak(1);

$section->addTitle("接口签名算法", 2);
$section->addTextBreak(1);
$signatureStyleName = 'signature';
$phpWord->addNumberingStyle(
    $signatureStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 720),
            array('format' => 'decimalEnclosedCircle', 'text' => '%2.', 'left' => 1440, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);
$section->addListItem('Sign的计算采用RSA2算法。', 0, null, $signatureStyleName);
$section->addListItem('Sign的参数计算方法如下：', 0, null, $signatureStyleName);
$section->addListItem('将所有参数（包含Sign本身）按照下面接口定义中参数从上到下顺序排列；', 1, null, $signatureStyleName);
$section->addListItem('将这些参数的值连接成一个字符串；', 1, null, $signatureStyleName);
$section->addListItem('将该字符串作为源字符串，将商户密钥作为 key，通过RSA2算法计算出Sign值；', 1, null, $signatureStyleName);
$section->addListItem('将Sign值添加到参数列表中，参数名称为 `sign`。', 1, null, $signatureStyleName);
$section->addListItem('请求报文加密的数据拼装完成。', 0, null, $signatureStyleName);

$section->addTextBreak(1);

$section->addTitle("回调应答机制", 2);
$section->addTextBreak(1);
$multilevelStyleName = 'callback';
$phpWord->addNumberingStyle(
    $multilevelStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);
$section->addListItem("应答机制：应答机制是指当商户收到支付成功数据通知（服务器点对点通讯形式）时，必须回写 `success` (不区分大小写)的响应，支付系统收到该应答，便认为商户已收到；否则通知 3 次，每次间隔 5 分钟。", 0, null, $multilevelStyleName);
$section->addListItem("回调机制：所有回调只有在成功时才会发起回调，失败不回调（如交易成功回调，失败不回调）。", 0, null, $multilevelStyleName);
$section->addListItem("不可靠机制：回调为不可靠回调（可能由于网络或者商户服务器问题导致回调失败），商户最好在回调的基础上主动查询订单状态。", 0, null, $multilevelStyleName);
$section->addTextBreak(1);
// Add Titles
$section->addTextBreak(1);

$section->addTitle('使用流程', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);

$manualStyleName = 'manual';
$phpWord->addNumberingStyle(
    $manualStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
            array('format' => 'upperLetter', 'text' => '%2.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);

$section->addListItem('准备阶段：', 0, null, $manualStyleName);
$section->addListItem('申请测试号等信息；', 1, null, $manualStyleName);
$section->addListItem('取得开发手册（本文档）等资料；', 1, null, $manualStyleName);
$section->addListItem('开发阶段：', 0, null, $manualStyleName);
$section->addListItem('根据提供的 DEMO 结合开发文档快速熟悉对接接口；', 1, null, $manualStyleName);
$section->addListItem('根据本系统提供的接口，在商户自己的系统上进行开发，实现所需要的业务功能；', 1, null, $manualStyleName);
$section->addListItem('对自己系统的业务功能进行全面测试；', 1, null, $manualStyleName);
$section->addListItem('与测试环境进行联调。', 1, null, $manualStyleName);
$section->addListItem('生产使用：', 0, null, $manualStyleName);
$section->addListItem('使用系统提供的正式资料。', 1, null, $manualStyleName);

$section->addTextBreak(1);
$section->addTextBreak(1);

$section->addTitle('接口说明', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);

$descriptionStyleName = 'description';
$phpWord->addNumberingStyle(
    $descriptionStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);

$section->addListItem('在未特别注明的情况下，所有的接口均可采用HTTP的POST提交方式发起请求，采用Application/json提交方式提交数据。', 0, null, $descriptionStyleName);
$section->addListItem('所有接口全部采用HTTPS请求方式。', 0, null, $descriptionStyleName);
$section->addListItem('数据返回格式为JSON串。', 0, null, $descriptionStyleName);


$section->addTextBreak(1);
$section->addTextBreak(1);

$section->addTitle('接口列表', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);

$section->addTitle('用户模块列表', 2);
$section->addTextBreak(1);

$html = '<p>TODO........</p>';

\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);


$section->addTextBreak(1);
for ($count = 3; $count--;) {
    $section->addTitle('获取用户信息接口', 3);
    $section->addTextBreak(1);
    $render = [
        [
            'param' => "name",
            'namely' => "你好",
            'isBool' => "必填",
            'desc' => "等方式尽快发货大",
        ],
        [
            'param' => "name",
            'namely' => "你好",
            'isBool' => "必填",
            'desc' => "等方式尽快发货大",
        ],
        [
            'param' => "name",
            'namely' => "你好",
            'isBool' => "必填",
            'desc' => "等方式尽快发货大",
        ],
        [
            'param' => "name",
            'namely' => "你好",
            'isBool' => "必填",
            'desc' => "等方式尽快发货大",
        ],
        [
            'param' => "name",
            'namely' => "你好",
            'isBool' => "必填",
            'desc' => "等方式尽快发货大",
        ],
    ];
    $tableGenerator = new TableGenerator($section,
        [
            'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
            'borderColor' => '282c34',
            'borderSize' => 7,
            'cellMargin' => 50,
            'alignment' => 'center'
        ]);
    $tableGenerator->setFirstCellStyle([
        'valign' => 'center',
        'bgColor' => 'd8d8d8',
    ]);
    $tableGenerator->setHeaderFStyle([
        'size' => '11',
        'bold' => true
    ]);
    $tableGenerator->setHeaderPStyle([
        'align' => 'center',
        'lineHeight' => 1,
    ]);
    $tableGenerator->setCellStyle([
        'valign' => 'center'
    ]);
    $tableGenerator->setFStyle([
        'size' => '10.5'
    ]);
    $tableGenerator->setPStyle([
        'align' => 'center',
        'lineHeight' => 1,
    ]);
    $tableGenerator->setExactHeight(false);
    $tableGenerator->generateTable([
        '参数' => 1500,
        '示例值' => 1800,
        '必填' => 1200,
        '参数说明' => 3500,
    ], $render);

    $section->addTextBreak(1);
}

// TODO： 创作一个cell的表格
// 然后给定背景元素
// 然后解析 html 塞入该元素中
$section->addTitle('获取用户列表接口', 3);
$section->addTextBreak(1);
$textRun = $section->addTable(['spacing' => 80, 'indentation' => ['left' => 800], 'bgColor' => 'D8D8D8']);
$result = json_encode(['name' => 'pis0sion', 'age' => 12, 'user' => ['id' => 5, 'nick_name' => 'gaoqiaoxue']], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$result = nl2br($result);
\PhpOffice\PhpWord\Shared\Html::addHtml($textRun, $result, false, false);
$section->addTextBreak(1);

$section->addTitle('订单模块列表', 2);
$section->addTextBreak(1);
$section->addText('订单列表的介绍');
$section->addTextBreak(1);


$section->addTitle('获取订单信息接口', 3);
$section->addTextBreak(1);
$section->addText('订单信息');
$section->addTextBreak(1);

$section->addTitle('用户下单接口', 3);
$section->addTextBreak(1);
$section->addText('用户下单');
$section->addTextBreak(1);
$section->addTextBreak(1);

$section->addTitle('生产环境资料', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);

$section->addTitle("如何获取服务器地址", 2);
$section->addTextBreak(1);
$section->addText("以阿里云为例，登录阿里云后台找到 ECS 控制台，找到公网地址，复制保存即可。", null, ['indentation' => ['firstLine' => 480]]);
$section->addTextBreak(1);

$multilevelNumberingStyleName = 'multilevel';
$phpWord->addNumberingStyle(
    $multilevelNumberingStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);
$section->addTitle("如何获取公钥和私钥", 2);
$section->addTextBreak(1);
$section->addText("登录系统服务上的后台，或者联系相关的技术指导人员进行获取。", null, ['indentation' => ['firstLine' => 480]]);
$section->addText("（关于密钥的保管：贵公司一定要保证密钥仅能被少数可靠的授权人知晓，严防密钥被不可信的人获取，如密钥泄露需立即进行修改同时替换程序中的密钥。）", ['color' => 'ff0000'], ['indentation' => ['firstLine' => 480]]);

$section->addTextBreak(1);
$section->addTextBreak(1);

$section->addTitle('接入导入', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);
$section->addTitle('如何快速导入', 2);
$section->addTextBreak(1);
$accessStyleName = 'access';
$phpWord->addNumberingStyle(
    $accessStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimalEnclosedCircle', 'text' => '%1.', 'left' => 900, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);
$section->addListItem('获取 DEMO 压缩包：', 0, null, $accessStyleName);
$section->addListItem('将请求地址改为测试环境请求地址；', 0, null, $accessStyleName);
$section->addListItem('目前仅有 PHP 范例；', 0, null, $accessStyleName);
$section->addListItem('将范例部署到您的应用服务器，并运行；', 0, null, $accessStyleName);
$section->addListItem('在测试环境上请调通接口；', 0, null, $accessStyleName);
$section->addListItem('请求和响应都调通后，便可在范例中加入您系统本身的业务逻辑，并再次在测试环境进行调试，直至通过；', 0, null, $accessStyleName);
$section->addListItem('将您正式的密钥配置到程序中，并将请求地址改为正式环境请求地址后便可上线。', 0, null, $accessStyleName);

$section->addTextBreak(1);
$section->addTitle('签名无效的解决方案', 2);
$section->addTextBreak(1);
$section->addText("解决方法：", null, ['indentation' => ['firstLine' => 480]]);
$section->addText("首先检查配置中的密钥是否与系统上提供的密钥一致,是否有中文。", null, ['indentation' => ['firstLine' => 480]]);
$section->addText("其次处理中文转码问题,有两个需要正确转码的环节：", null, ['indentation' => ['firstLine' => 480]]);
$resolveStyleName = 'resolve';
$phpWord->addNumberingStyle(
    $resolveStyleName,
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimalEnclosedCircle', 'text' => '%1.', 'left' => 900, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);
$section->addListItem('涉及中文的参数在传入生成sign的方法时，不能是乱码。', 0, null, $resolveStyleName);
$section->addListItem('生成请求参数后，涉及中文的参数的值不能是乱码，当前仅支持UTF-8的编码格式。', 0, null, $resolveStyleName);

$section->addPageBreak();

$section->addTitle('附录', 1);       // 添加主题，并且写入目录
$section->addTextBreak(1);
$section->addTitle('返回码列表', 2);       // 添加主题，并且写入目录
$section->addTextBreak(1);
$appendix = [
    [
        'param' => "SYS_API_0000",
        'namely' => "成功！",
    ],
    [
        'param' => "SYS_API_999",
        'namely' => "注册参数校验失败/抱歉,白名单参数有误！/ 抱歉,冻结天数超出范围！/ 传入的参数有误！",
    ],
    [
        'param' => "SYS_API_998",
        'namely' => "调用接口失败。",
    ],
    [
        'param' => "SYS_API_997",
        'namely' => "附件大小不符合规范。",
    ],
    [
        'param' => "",
        'namely' => "",
    ],
    [
        'param' => "",
        'namely' => "",
    ],
    [
        'param' => "",
        'namely' => "",
    ],
    [
        'param' => "",
        'namely' => "",
    ],
];
$tableVersion = new TableGenerator($section);
$tableVersion->setFirstCellStyle([
    'valign' => 'center',
    'bgColor' => 'D8D8D8',
]);
$tableVersion->setHeaderFStyle([
    'size' => '11',
    'bold' => true
]);
$tableVersion->setHeaderPStyle([
    'align' => 'center',
    'lineHeight' => 1,
]);
$tableVersion->setCellStyle([
    'valign' => 'center'
]);
$tableVersion->setFStyle([
    'size' => '10.5'
]);
$tableVersion->setPStyle([
    'align' => 'center',
    'lineHeight' => 1,
]);
$tableVersion->setExactHeight(false);
$tableVersion->generateTable([
    '返回码' => 2000,
    '说明' => 7000,
], $appendix);
$section->addTextBreak(1);

echo date('H:i:s'), ' Note: Please refresh TOC manually.', PHP_EOL;

$filename = time() . uniqid() . ".docx";
$phpWord->save($filename);