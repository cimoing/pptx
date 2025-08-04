<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Common\TraitArrayAccess;
use Imoing\Pptx\OXml\Presentation\CTSlideId;
use Imoing\Pptx\OXml\Presentation\CTSlideIdList;
use Imoing\Pptx\Parts\Presentation\PresentationPart;
use Imoing\Pptx\Presentation;
use Imoing\Pptx\Shared\ParentedElementProxy;
use Traversable;

/**
 * @property PresentationPart $part;
 */
class Slides extends ParentedElementProxy implements \ArrayAccess,\IteratorAggregate,\Countable
{
    use TraitArrayAccess;
    protected CTSlideIdList $_sldIdLst;
    public function __construct(CTSlideIdList $sldIdLst, Presentation $presentation)
    {
        parent::__construct($sldIdLst, $presentation);
        $this->_sldIdLst = $sldIdLst;
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        foreach ($this->_sldIdLst->sldId_lst as $sldId) {
            yield $this->part->relatedSlide($sldId->rId);
        }
    }

    public function offsetGet($offset): Slide
    {
        $sldId = $this->_sldIdLst->sldId_lst[$offset];
        return $this->part->relatedSlide($sldId->rId);
    }

    public function count(): int
    {
        return count($this->_sldIdLst->sldId_lst);
    }

    public function addSlide(SlideLayout $slideLayout): Slide
    {
        list($rId, $slide) = $this->part->addSlide($slideLayout);

        $slide->shapes->cloneLayoutPlaceholders($slideLayout);
        $this->_sldIdLst->add_sldId($rId);

        return $slide;
    }
}