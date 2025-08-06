<?php

namespace Imoing\Pptx\Parts\Slide;

use Imoing\Pptx\Opc\Constants\ContentType;
use Imoing\Pptx\Opc\Constants\RT;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\OXml\Slide\CTSlide;
use Imoing\Pptx\Package\Package;
use Imoing\Pptx\Slide\NotesSlide;
use Imoing\Pptx\Slide\Slide;
use Imoing\Pptx\Slide\SlideLayout;

/**
 * @property-read bool $hasNotesSlide
 * @property-read NotesSlide $notesSlide
 * @property-read Slide $slide
 * @property-read int $slideId
 * @property-read SlideLayout $slideLayout
 */
class SlidePart extends BaseSlidePart
{
    protected static string $nsTag = 'p:sld';

    public static function create(PackURI $partName, Package $package, SlideLayoutPart $slideLayoutPart): self
    {
        $slidePart = new static($partName, ContentType::PML_SLIDE, $package, CTSlide::create());
        $slidePart->relateTo($slideLayoutPart, RT::SLIDE_LAYOUT);

        return $slidePart;
    }

    public function isHasNotesSlide(): bool
    {
        return $this->hasNotesSlide;
    }

    public function getNotesSlide(): NotesSlide
    {
        try {
            $slidePart = $this->partRelatedBy(RT::NOTES_SLIDE);
        } catch (\Exception $e) {
            $slidePart = $this->addNotesSlidePart();
        }

        return $slidePart;
    }

    private ?Slide $_slide = null;
    public function getSlide(): Slide
    {
        if ($this->_slide == null) {
            $this->_slide = new Slide($this->_element, $this);
        }
        return $this->_slide;
    }

    private ?int $_slideId = null;
    public function getSlideId(): int
    {
        if ($this->_slideId == null) {
            $presentationPart = $this->getPackage()->presentationPart;
            $this->_slideId = $presentationPart->getSlideId($this);
        }

        return $this->_slideId;
    }

    private ?SlideLayout $_slideLayout = null;
    public function getSlideLayout(): SlideLayout
    {
        if ($this->_slideLayout == null) {
            $layoutPart = $this->partRelatedBy(RT::SLIDE_LAYOUT);
            assert($layoutPart instanceof SlideLayoutPart);
            $this->_slideLayout = $layoutPart->getSlideLayout();
        }
        return $this->_slideLayout;
    }

    private function addNotesSlidePart()
    {
        $slidePart = NotesSlidePart::create($this->package,$this);
        $this->relateTo($slidePart, RT::NOTES_SLIDE);

        return $slidePart;
    }

    public function getTheme()
    {
        return $this->getSlideLayout()->getSlideMaster();
    }
}