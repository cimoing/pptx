<?php

namespace Imoing\Pptx;

interface IPresentation
{
    /**
     * @return array
     */
    public function getCoreProperties(): array;
    /**
     * 保存文件
     * @param string $path 文件路径或文件句柄
     * @return void
     */
    public function save(string $path): void;

    public static function load(?string $path): IPresentation;
}