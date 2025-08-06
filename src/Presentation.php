<?php

namespace Imoing\Pptx;

use Imoing\Pptx\OXml\Presentation\CTPresentation;
use Imoing\Pptx\Package\Package;
use Imoing\Pptx\Parts\CoreProps\CorePropertiesPart;
use Imoing\Pptx\Parts\Presentation\PresentationPart;
use Imoing\Pptx\Shared\PartElementProxy;
use Imoing\Pptx\Slide\SlideLayouts;
use Imoing\Pptx\Slide\SlideMaster;
use Imoing\Pptx\Slide\SlideMasters;
use Imoing\Pptx\Slide\Slides;
use Imoing\Pptx\Util\Length;

/**
 * @method CTPresentation getElement()
 * @property PresentationPart $part;
 * @property CorePropertiesPart $coreProperties
 * @property SlideLayouts $slideLayouts
 * @property SlideMasters $slideMasters
 * @property-read CTPresentation $_element
 * @property-read Slides $slides
 */
class Presentation extends PartElementProxy
{
    public static function create(?string $pptx = null): static
    {
        if (empty($pptx)) {
            $pptx = _defaultPptxPath();
        }

        return self::load($pptx);
    }

    /**
     * 打开PPT
     * @param string $fileName
     * @return Presentation
     */
    public static function load(string $fileName): static
    {
        $package = Package::open($fileName);
        $part = $package->getMainDocumentPart();

        return $part->getPresentation();
    }

    protected function getCoreProperties(): Parts\CoreProps\CorePropertiesPart
    {
        return $this->part->coreProperties;
    }

    public function save(string $file): void
    {
        $this->part->save($file);
    }

    public function getSlideLayouts(): SlideLayouts
    {
        return $this->slideMasters[0]->slideLayouts;
    }

    protected function getSlideMaster(): SlideMaster
    {
        return $this->slideMasters[0];
    }

    private ?SlideMasters  $_slideMasters = null;
    protected function getSlideMasters(): SlideMasters
    {
        if (is_null($this->_slideMasters)) {
            $this->_slideMasters = new SlideMasters($this->_element->get_or_add_sldMasterIdLst(), $this);
        }

        return $this->_slideMasters;
    }

    public function getSlideHeight(): ?Length
    {
        $sldSz = $this->getElement()->sldSz;
        if (is_null($sldSz)) {
            return null;
        }

        return $sldSz->cy;
    }

    public function setSlideHeight(Length $height): void
    {
        $sldSz = $this->getElement()->get_or_add_sldSz();
        $sldSz->cy = $height;
    }

    private ?Slides $_slides = null;
    protected function getSlides(): Slides
    {
        if (is_null($this->_slides)) {
            $sldIdLst = $this->_element->get_or_add_sldIdLst();
            $items = [];
            foreach ($sldIdLst->sldId_lst as $sldId) {
                $items[] = $sldId->rId;
            }
            $this->part->renameSlideParts(new \ArrayIterator($items));
            $this->_slides = new Slides($sldIdLst,$this);
        }

        return $this->_slides;
    }
}