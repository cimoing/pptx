<?php

namespace Imoing\Pptx\OXml\Presentation;

use Imoing\Pptx\OXml\SimpleTypes\STSlideSizeCoordinate;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\Util\Length;

/**
 * `p:sldSz`元素
 * <p:presentation>的子元素，包含页面在ppt中的宽高
 * @property Length $cx
 * @property Length $cy
 */
class CTSlideSize extends BaseOXmlElement
{
    #[RequiredAttribute("cx", STSlideSizeCoordinate::class)]
    protected Length $cx;

    #[RequiredAttribute("cy", STSlideSizeCoordinate::class)]
    protected Length $cy;
}