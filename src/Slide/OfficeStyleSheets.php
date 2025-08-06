<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Shared\ParentedElementProxy;

class OfficeStyleSheets extends ParentedElementProxy implements \IteratorAggregate
{
    protected ?array $_themes = null;

}