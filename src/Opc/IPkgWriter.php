<?php

namespace Imoing\Pptx\Opc;

interface IPkgWriter
{
    /**
     * @param string $pkgFile 写入的路径或目录
     * @return self
     */
    public static function factory(string $pkgFile): self;

    /**
     * @param string $packUri 包内路径
     * @param string $blob 内容
     * @return void
     */
    public function write(string $packUri, string $blob): void;

    /**
     * 执行结束清理操作
     * @return void
     */
    public function close(): void;
}