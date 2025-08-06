<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Slide\CTSlideLayoutIdList;
use Imoing\Pptx\Parts\Slide\SlideMasterPart;
use Imoing\Pptx\Shared\ParentedElementProxy;
use IteratorAggregate;
use Traversable;

/**
 * @property SlideMasterPart $part
 * @property SlideMaster $parent
 */
class SlideLayouts extends ParentedElementProxy implements IteratorAggregate
{

    protected CTSlideLayoutIdList $_sldLayoutIdLst;

    public function __construct(CTSlideLayoutIdList $sldLayoutIdLst, SlideMaster $parent)
    {
        parent::__construct($sldLayoutIdLst, $parent);
        $this->_sldLayoutIdLst = $sldLayoutIdLst;
    }

    public function item($idx): SlideLayout
    {
        $id = $this->_sldLayoutIdLst->sldLayoutId_lst[$idx];
        return $this->part->getRelatedSlideLayout($id->rId);
    }

    /**
     * @return Traversable<int,SlideLayout>
     */
    public function getIterator(): Traversable
    {
        foreach ($this->_sldLayoutIdLst->sldLayoutId_lst as $sldLayoutId) {
            yield $this->part->getRelatedSlideLayout($sldLayoutId->rId);
        }
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this as $layout) {
            $result[] = $layout->toArray();
        }

        return $result;
    }
}