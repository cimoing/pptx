<?php

namespace Imoing\Pptx\Parts\Presentation;

use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\XmlPart;
use Imoing\Pptx\OXml\Presentation\CTPresentation;
use Imoing\Pptx\Parts\CoreProps\CorePropertiesPart;
use Imoing\Pptx\Parts\Slide\SlideMasterPart;
use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Presentation;
use Imoing\Pptx\Slide\Slide;
use Imoing\Pptx\Slide\SlideLayout;
use Imoing\Pptx\Slide\SlideMaster;

/**
 * @property-read CTPresentation $_element
 * @property CorePropertiesPart $coreProperties
 */
class PresentationPart extends XmlPart
{
    protected static string $nsTag = 'p:presentation';
    public function addSlide(SlideLayout $slideLayout): array
    {
        $partName = $this->getNextSlidePartName();
        $layoutPart = $slideLayout->part;
        $slidePart = SlidePart::create($partName, $this->_package, $layoutPart);
        $rId = $this->relateTo($slidePart, RT::SLIDE);

        return [$rId, $slidePart->slide];
    }

    protected function getCoreProperties(): CorePropertiesPart
    {
        return $this->_package->getCoreProperties();
    }

    public function getSlide(int $slideId): ?Slide
    {

    }


    public function getPresentation(): Presentation
    {
        return new Presentation($this->_element, $this);
    }

    public function relatedSlide(string $rId): Slide
    {
        $obj = $this->relatedPart($rId);
        assert($obj instanceof SlidePart);
        return $obj->slide;
    }

    public function relatedSlideMaster(string $rId): SlideMaster
    {
        $part = $this->relatedPart($rId);
        assert($part instanceof SlideMasterPart);
        $obj =  $part->slideMaster;
        assert($obj instanceof SlideMaster);
        return $obj;
    }

    public function renameSlideParts(\Traversable $rIds): void
    {
        foreach ($rIds as $idx => $rId) {
            $slidePart = $this->relatedPart($rId);
            $partName = new PackURI(sprintf("/ppt/slides/slide%d.xml", $idx+1));
            $slidePart->setPartName($partName);
        }
    }


    public function save(string $pathOrStream): void
    {
        $this->getPackage()->save($pathOrStream);
    }

    public function getSlideId($slidePart): int
    {
        foreach ($this->_element->sldIdLst->sldId_lst as $sldId) {
            if($this->relatedPart($sldId->rId) == $slidePart) {
                return $sldId->id;
            };
        }

        throw new \Exception("matching slide_part not found");
    }

    protected function getNextSlidePartName(): PackURI
    {
        $sldIdLst = $this->_element->get_or_add_sldIdLst();
        $partNameStr = sprintf("/ppt/slides/slide%d.xml", count($sldIdLst->sldId_lst) + 1);

        return new PackURI($partNameStr);
    }
}