<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Common\TraitArrayAccess;
use Imoing\Pptx\OXml\Presentation\CTSlideMasterIdList;
use Imoing\Pptx\Parts\Presentation\PresentationPart;
use Imoing\Pptx\Presentation;
use Imoing\Pptx\Shared\ParentedElementProxy;
use Traversable;

/**
 * @property PresentationPart $part
 */
class SlideMasters extends ParentedElementProxy implements \ArrayAccess,\IteratorAggregate,\Countable
{
    use TraitArrayAccess;
    protected CTSlideMasterIdList|null $_sldMasterIdLst = null;
    public function __construct(CTSlideMasterIdList $slideMasterIdList, Presentation $parent)
    {
        parent::__construct($slideMasterIdList, $parent);
        $this->_sldMasterIdLst = $slideMasterIdList;
    }

    public function offsetGet($offset): SlideMaster
    {
        $sldMasterId = $this->_sldMasterIdLst->sldMasterId_lst[$offset];
        return $this->part->relatedSlideMaster($sldMasterId->rId);
    }

    public function getIterator(): Traversable
    {
        foreach ($this->_sldMasterIdLst->sldMasterId_lst as $sldMasterId) {
            yield $this->part->relatedSlideMaster($sldMasterId->rId);
        }
    }

    public function count(): int
    {
        return count($this->_sldMasterIdLst->sldMasterId_lst);
    }
}