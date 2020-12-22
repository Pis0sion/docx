<?php


namespace Pis0sion\Docx\entity;

use PhpOffice\PhpWord\Element\Section;
use Pis0sion\Docx\layer\AbsBaseEntity;
use Pis0sion\Docx\servlet\TableServlet;

/**
 * 简介
 * Class IntroductionEntity
 * @package Pis0sion\Docx\entity
 */
class IntroductionEntity extends AbsBaseEntity
{
    /**
     * 创建简介
     */
    public function run()
    {
        $this->addCategoriesTitle("文档简介", 1);
        $this->addCategoriesTitle("特别声明", 2, function ($section) {
            $section->addText("未得到本公司的书面许可，不得为任何目的、以任何形式或手段（包括但不限于机械的或电子的）复制或传播本文档的任何部分。对于本文档涉及的技术和产品，本公司拥有其专利（或正在申请专利）、商标、版权或其它知识产权。除非得到本公司的书面许可协议，本文档不授予这些专利、商标、版权或其它知识产权的许可。", null, ['indentation' => ['firstLine' => 480]]);
            $section->addText("本文档因产品功能示例和描述的需要，所使用的任何人名、企业名和数据都是虚构的，并仅限于本公司内部测试使用，不等于本公司有对任何第三方的承诺和宣传。", null, ['indentation' => ['firstLine' => 480]]);
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("阅读对象", 2, function ($section) {
            /** @var Section $section */
            $section->addText("贵公司的技术部门的开发、维护及管理人员，应具备以下基本知识：", null, ['indentation' => ['firstLine' => 480]]);
            $section->addListItem("了解HTTPS/HTTP协议等内容。", 0, null, "readObject");
            $section->addListItem("了解信息安全的基本概念。", 0, null, "readObject");
            $section->addListItem("了解计算机至少一种编程语言。", 0, null, "readObject");
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("产品说明", 2, function ($section) {
            $section->addText("本开发手册对该系统功能接口进行详细的描述，通过该指南可以对本系统有全面的了解，使技术人员尽快掌握本系统的接口，并能够在本系统上进行开发。", null, ['indentation' => ['firstLine' => 480]]);
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("名词解释", 2, function ($section) {
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
            (new TableServlet($section))->run([
                '名词缩写' => 2500,
                '名词定义' => 5500,
            ], $glossary);
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("接口签名算法", 2, function ($section) {
            /** @var Section $section */
            $section->addListItem('Sign的计算采用RSA2算法。', 0, null, "signature");
            $section->addListItem('Sign的参数计算方法如下：', 0, null, "signature");
            $section->addListItem('将所有参数（包含Sign本身）按照下面接口定义中参数从上到下顺序排列；', 1, null, "signature");
            $section->addListItem('将这些参数的值连接成一个字符串；', 1, null, "signature");
            $section->addListItem('将该字符串作为源字符串，将商户密钥作为 key，通过RSA2算法计算出Sign值；', 1, null, "signature");
            $section->addListItem('将Sign值添加到参数列表中，参数名称为 `sign`。', 1, null, "signature");
            $section->addListItem('请求报文加密的数据拼装完成。', 0, null, "signature");
            $section->addTextBreak(1);
        });
        $this->addCategoriesTitle("回调应答机制", 2, function ($section) {
            /** @var Section $section */
            $section->addListItem("应答机制：应答机制是指当商户收到支付成功数据通知（服务器点对点通讯形式）时，必须回写 `success` (不区分大小写)的响应，支付系统收到该应答，便认为商户已收到；否则通知 3 次，每次间隔 5 分钟。", 0, null, "callback");
            $section->addListItem("回调机制：所有回调只有在成功时才会发起回调，失败不回调（如交易成功回调，失败不回调）。", 0, null, "callback");
            $section->addListItem("不可靠机制：回调为不可靠回调（可能由于网络或者商户服务器问题导致回调失败），商户最好在回调的基础上主动查询订单状态。", 0, null, "callback");
            $section->addTextBreak(1);
            $section->addTextBreak(1);
        });
    }
}