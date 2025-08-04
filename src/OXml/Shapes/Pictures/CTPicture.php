<?php

namespace Imoing\Pptx\OXml\Shapes\Pictures;

use Imoing\Pptx\OXml\Dml\Fill\CTBlipFillProperties;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\OXml\Shapes\Shared\CTShapeProperties;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\Util\Length;

/**
 * @property CTShapeProperties $spPr
 * @property CTBlipFillProperties $blipFill
 * @property CTPictureNonVisual $nvPicPr
 * @property ?string $blipRId
 */
class CTPicture extends BaseShapeElement
{
    #[OneAndOnlyOne("p:nvPicPr")]
    protected mixed $_nvPicPr;

    #[OneAndOnlyOne("p:blipFill")]
    protected mixed $_blipFill;

    #[OneAndOnlyOne("p:spPr")]
    protected CTShapeProperties $_spPr;

    public function getBlipRId(): ?string
    {
        $blip = $this->blipFill->blip;
        if (!is_null($blip) && !is_null($blip->rEmbed)) {
            return $blip->rEmbed;
        }

        return null;
    }

    public function cropToFit($imageSize, $viewSize): void
    {
        $this->blipFill->crop($this->getFillCropping($imageSize, $viewSize));
    }

    public function get_or_add_ln(): CTLineProperties
    {
        return $this->spPr->get_or_add_ln();
    }

    public function getLn(): ?CTLineProperties
    {
        return $this->spPr->ln;
    }

    public static function createPhPic(\DOMDocument $dom, int $id, string $name, string $desc, string $rId): CTPicture
    {
        $xml = sprintf(
        "<p:pic %s>\n".
            "  <p:nvPicPr>\n".
            '    <p:cNvPr id="%d" name="%s" descr="%s"/>'.
            "    <p:cNvPicPr>\n".
            '      <a:picLocks noGrp="1" noChangeAspect="1"/>'.
            "    </p:cNvPicPr>\n".
            "    <p:nvPr/>\n".
            "  </p:nvPicPr>\n".
            "  <p:blipFill>\n".
            '    <a:blip r:embed="%s"/>'.
            "    <a:stretch>\n".
            "      <a:fillRect/>\n".
            "    </a:stretch>\n".
            "  </p:blipFill>\n".
            "  <p:spPr/>\n".
            "</p:pic>", nsdecls(["p", "a", "r"]), $id, $name, $desc, $rId);

        $sp = makeOXmlElement($dom, $xml);
        assert($sp instanceof CTPicture);

        return $sp;
    }

    public static function createPic(\DOMDocument $dom, int $shapeId, string $name, string $desc, string $rId, int $x, int $y, int $cx, int $cy): CTPicture
    {
        $xml = sprintf(
            "<p:pic %s>\n".
            "  <p:nvPicPr>\n".
            '    <p:cNvPr id="%d" name="%s" descr="%s"/>'.
            "    <p:cNvPicPr>\n".
            '      <a:picLocks noChangeAspect="1"/>'.
            "    </p:cNvPicPr>\n".
            "    <p:nvPr/>\n".
            "  </p:nvPicPr>\n".
            "  <p:blipFill>\n".
            '    <a:blip r:embed="%s"/>'.
            "    <a:stretch>\n".
            "      <a:fillRect/>\n".
            "    </a:stretch>\n".
            "  </p:blipFill>\n".
            "  <p:spPr>\n".
            "    <a:xfrm>\n".
            '      <a:off x="%d" y="%d"/>'.
            '      <a:ext cx="%d" cy="%d"/>'.
            "    </a:xfrm>\n".
            '    <a:prstGeom prst="rect">'.
            "      <a:avLst/>\n".
            "    </a:prstGeom>\n".
            "  </p:spPr>\n".
            "</p:pic>",nsdecls(["a", "p", "r"]), $shapeId, $name, $desc, $rId, $x, $y, $cx, $cy);

        $sp = makeOXmlElement($dom, $xml);
        assert($sp instanceof CTPicture);

        return $sp;
    }

    public static function createVideoPic(\DOMDocument $dom, int $shapeId, string $shapeName, string $videoRId, string $mediaRId, string $posterFrameRId, Length $x, Length $y, Length $cx, Length $cy): CTPicture
    {
        $xml = sprintf(
            "<p:pic %s>\n".
            "  <p:nvPicPr>\n".
            '    <p:cNvPr id="%d" name="%s">'.
            '      <a:hlinkClick r:id="" action="ppaction://media"/>'.
            "    </p:cNvPr>\n".
            "    <p:cNvPicPr>\n".
            '      <a:picLocks noChangeAspect="1"/>'.
            "    </p:cNvPicPr>\n".
            "    <p:nvPr>\n".
            '      <a:videoFile r:link="%s"/>'.
            "      <p:extLst>\n".
            '        <p:ext uri="{DAA4B4D4-6D71-4841-9C94-3DE7FCFB9230}">'.
            '          <p14:media xmlns:p14="http://schemas.microsoft.com/of'.
            'fice/powerpoint/2010/main" r:embed="%s"/>'.
            "        </p:ext>\n".
            "      </p:extLst>\n".
            "    </p:nvPr>\n".
            "  </p:nvPicPr>\n".
            "  <p:blipFill>\n".
            '    <a:blip r:embed="%s"/>'.
            "    <a:stretch>\n".
            "      <a:fillRect/>\n".
            "    </a:stretch>\n".
            "  </p:blipFill>\n".
            "  <p:spPr>\n".
            "    <a:xfrm>\n".
            '      <a:off x="%d" y="%d"/>'.
            '      <a:ext cx="%d" cy="%d"/>'.
            "    </a:xfrm>\n".
            '    <a:prstGeom prst="rect">'.
            "      <a:avLst/>\n".
            "    </a:prstGeom>\n".
            "  </p:spPr>\n".
            "</p:pic>", nsdecls(["a", "p", "r"]), $shapeId, $shapeName, $videoRId, $mediaRId, $posterFrameRId, $x->getEmu(), $y->getEmu(), $cx->getEmu(), $cy->getEmu());
        $sp = makeOXmlElement($dom, $xml);
        assert($sp instanceof CTPicture);

        return $sp;
    }

    public function getSrcRectB(): float
    {
        return $this->getSrcRectX("b");
    }

    public function setSrcRectB($value): void
    {
        $this->blipFill->get_or_add_srcRect()->b = $value;
    }

    public function getSrcRectL(): float
    {
        return $this->getSrcRectX("l");
    }

    public function setSrcRectL($value): void
    {
        $this->blipFill->get_or_add_srcRect()->l = $value;
    }

    public function getSrcRectR(): float
    {
        return $this->getSrcRectX("r");
    }

    public function setSrcRectR($value): void
    {
        $this->blipFill->get_or_add_srcRect()->r = $value;
    }

    public function getSrcRectT(): float
    {
        return $this->getSrcRectX("b");
    }

    public function setSrcRectT($value): void
    {
        $this->blipFill->get_or_add_srcRect()->t = $value;
    }


    protected function getSrcRectX(string $attrName): float
    {
        $srcRect = $this->blipFill->srcRect;
        if (is_null($srcRect)) {
            return 0.0;
        }

        return $srcRect->$attrName;
    }

    protected function getFillCropping(array $imageSize, array $viewSize): array
    {
        $aspect_ratio = function ($width, $height) {
            return $width / $height;
        };

        $arView = $aspect_ratio(...$viewSize);
        $arImage = $aspect_ratio(...$imageSize);

        if ($arView < $arImage) {
            $crop = (1.0 - ($arView / $arImage)) / 2.0;
            return [$crop, 0.0, $crop, 0.0];
        }

        if ($arView > $arImage) {
            $crop = (1.0 - ($arImage / $arView)) / 2.0;
            return [0.0, $crop, 0.0, $crop];
        }

        return [0.0,0.0,0.0,0.0];
    }
}