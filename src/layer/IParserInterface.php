<?php


namespace Pis0sion\Docx\layer;

/**
 * Interface IParserInterface
 * @package Pis0sion\Docx\layer
 */
interface IParserInterface
{
    /**
     * @param string $postmanJson
     * @return array
     */
    public function parse2RenderDocx(string $postmanJson): array;
}