<?php

namespace Imoing\Pptx\Types;

use Imoing\Pptx\Util\Length;

interface ProvidesExtends
{
    public function getHeight(): Length;

    public function getWidth(): Length;
}