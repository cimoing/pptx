<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\Dml\Fill\Fill;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShapeNonVisual;
use Imoing\Pptx\OXml\Text\CTTextBody;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Util\Length;

/**
 * @property CTShapeProperties $spPr
 * @property Length $x
 * @property Length $y
 * @property Length  $cx
 * @property Length $cy
 * @property bool $flipH
 * @property bool $flipV
 * @property BaseOXmlElement $nvXxPr
 * @property-read bool $hasPhElm
 * @property-read  string $shapeName
 * @property float $rot
 * @property int $shapeId
 * @property-read ?CTPlaceholder $ph
 * @property-read int $phIdx
 * @property-read string $phOrient
 * @property-read string $phSz
 * @property-read PPPlaceholderType $phType
 * @property-read ?CTTextBody $txBody
 */
class BaseShapeElement extends BaseOXmlElement
{
    public function getCx(): ?Length
    {
        return $this->getXfrmAttr("cx");
    }

    public function setCx($value): void
    {
        $this->setXfrmAttr("cx", $value);
    }

    public function getCy(): ?Length
    {
        return $this->getXfrmAttr("cy");
    }

    public function setCy($value): void
    {
        $this->setXfrmAttr("cy", $value);
    }

    public function getFlipH(): bool
    {
        return (bool) $this->getXfrm()?->flipH;
    }

    public function setFlipH($value): void
    {
        $xfrm = $this->get_or_add_xfrm();
        $xfrm->flipH = $value;
    }

    public function getFlipV(): bool
    {
        return (bool) $this->getXfrm()?->flipV;
    }

    public function setFlipV($value): void
    {
        $xfrm = $this->get_or_add_xfrm();
        $xfrm->flipV = $value;
    }

    public function getFill(): ?Fill
    {
        $spPr = $this->spPr;
        if (empty($spPr) || empty($spPr->eg_fillProperties)) {
            return null;
        }

        return Fill::create($spPr->eg_fillProperties);
    }

    public function getFillFormat(): FillFormat
    {
        return FillFormat::fromFillParent($this->spPr);
    }

    public function get_or_add_xfrm(): CTTransform2D
    {
        return $this->spPr->get_or_add_xfrm();
    }

    public function getHasPhElm(): bool
    {
        return !empty($this->getPh());
    }

    public function getPh(): ?CTPlaceholder
    {
        $nodes = $this->xpath("./*[1]/p:nvPr/p:ph");
        if ($nodes->count() == 0) {
            return null;
        }

        $obj = NsMap::castDom($nodes->item(0));
        assert($obj instanceof CTPlaceholder);
        return $obj;
    }

    public function getPhIdx(): int
    {
        $ph = $this->getPh();
        if ($ph == null) {
            throw new \Exception("not a placeholder shape");
        }

        return $ph->idx;
    }

    public function getPhOrient(): string
    {
        $ph = $this->getPh();
        if ($ph == null) {
            throw new \Exception("not a placeholder shape");
        }

        return $ph->orient;
    }

    public function getPhSz(): string
    {
        $ph = $this->getPh();
        if ($ph == null) {
            throw new \Exception("not a placeholder shape");
        }
        return $ph->sz;
    }

    public function getPhType(): PPPlaceholderType
    {
        $ph = $this->getPh();
        if ($ph == null) {
            throw new \Exception("not a placeholder shape");
        }
        return $ph->type;
    }

    public function getRot(): float
    {
        $xfrm = $this->getXfrm();
        if (is_null($xfrm) || is_null($xfrm->rot)) {
            return 0.0;
        }

        return $xfrm->rot;
    }

    public function setRot(float $value): void
    {
        $this->get_or_add_xfrm()->rot = $value;
    }

    public function getShapeId()
    {
        return $this->getNvXxPr()->cNvPr->id;
    }

    public function getShapeName(): string
    {
        return $this->getNvXxPr()->cNvPr->name;
    }

    public function getTxBody(): ?CTTextBody
    {
        $nodes = $this->getElementsByNsTagName("p:txBody");
        if ($nodes->count() == 0) {
            return null;
        }
        $obj = NsMap::castDom($nodes->item(0));
        assert($obj instanceof CTTextBody);
        return $obj;
    }

    public function getX(): ?Length
    {
        return $this->getXfrmAttr('x');
    }

    public function setX(Length $value): void
    {
        $this->setXfrmAttr('x', $value);
    }

    public function getXfrm(): ?CTTransform2D
    {
        return $this->spPr->xfrm;
    }

    public function getY(): ?Length
    {
        return $this->getXfrmAttr('y');
    }

    public function setY(Length $value): void
    {
        $this->setXfrmAttr('y', $value);
    }

    protected function getNvXxPr()
    {
        $node = $this->xpath("./*[1]", 'p:nvGrpSpPr')->item(0);
        return NsMap::castDom($node);
    }

    private function getXfrmAttr(string $name): ?Length
    {
        $xfrm = $this->getXfrm();
        return $xfrm?->$name;

    }

    private function setXfrmAttr(string $name, $value): void
    {
        $xfrm = $this->get_or_add_xfrm();
        $xfrm->$name = $value;
    }
}