<?php

namespace Imoing\Pptx\Shapes\AutoShape;

use Imoing\Pptx\Common\Point;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Dml\Line\LineFormat;
use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DClose;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DCubicBezTo;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DLineTo;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPath2DMoveTo;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\OXml\SimpleTypes\Formula;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Base\TextLevelParaStyle;
use Imoing\Pptx\Shapes\ShapeTree\LayoutPlaceholders;
use Imoing\Pptx\Text\Text\TextFrame;
use Imoing\Pptx\Types\ProvidesPart;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property-read  TextFrame $textFrame
 * @property string $text
 * @property-read ?MsoAutoShapeType $autoShapeType
 * @property-read FillFormat $fill
 * @property-read bool $hasTextFrame
 * @property-read LineFormat $line
 */
class Shape extends BaseShape
{
    protected CTShape $_sp;
    public function __construct(CTShape $shape, ProvidesPart $part)
    {
        parent::__construct($shape, $part);
        $this->_sp = $shape;
    }

    public function getSchemeColor(string $scheme): string
    {
        return $this->_parent->theme->getSchemeColor($scheme);
    }

    public function getAutoShapeType(): ?\Imoing\Pptx\Enum\MsoAutoShapeType
    {
        if (!($this->_sp->isAutoShape)) {
            throw new \Exception("shape is not an auto shape");
        }

        return $this->_sp->prst;
    }

    public function get_or_add_ln(): CTLineProperties
    {
        return $this->_sp->get_or_add_ln();
    }

    public function getHasTextFrame(): bool
    {
        return true;
    }

    private ?LineFormat $_line = null;
    public function getLine(): LineFormat
    {
        if (is_null($this->_line)) {
            $this->_line = new LineFormat($this, $this->theme);
        }

        return $this->_line;
    }

    private ?CTLineProperties $_ln = null;
    public function getLn(): CTLineProperties
    {
        if (is_null($this->_ln)) {
            $this->_ln = $this->_sp->get_or_add_ln();
        }
        return $this->_ln;
    }

    public function getShapeType(): MsoShapeType
    {
        if ($this->isPlaceholder) {
            return MsoShapeType::PLACEHOLDER;
        }
        if ($this->_sp->getHasCustomGeometry()) {
            return MsoShapeType::FREEFORM;
        }
        if ($this->_sp->getIsTextBox()) {
            return MsoShapeType::TEXT_BOX;
        }

        if ($this->_sp->spPr->prstGeom->prst) {
            return MsoShapeType::AUTO_SHAPE;
        }

        throw new \Exception("Shape instance of unrecognized shape type");
    }

    public function getText(): string
    {
        return $this->textFrame->text;
    }

    public function setText(string $text): void
    {
        $this->textFrame->text = $text;
    }

    public function getTextFrame(): ?TextFrame
    {
        $txBody = $this->_sp->txBody;
        if (empty($txBody)) {
            return null;
        }
        return new TextFrame($txBody, $this);
    }

    public function getLevelPPr(int $level): ?CTLevelParaProperties
    {
        $ph = $this->_element->getPh();
        if (empty($ph)) {
            return null;
        }

        return $this->_parent->parent->getPhLevelPPr($ph->idx, $level);
    }

    private ?TextLevelParaStyle $_textLevelParaStyle = null;
    public function getTextLevelParaStyle(): TextLevelParaStyle
    {
        if (is_null($this->_textLevelParaStyle)) {
            $ph = $this->_element->getPh();
            if (!empty($ph)) {
                $placeholder = $this->_parent->getLayoutPlaceholders()->get($ph->idx);
                if ($placeholder) {
                    $this->_textLevelParaStyle = $placeholder->getTextLevelParaStyle();
                } else {
                    $placeholder = $this->_parent->getLayoutPlaceholders()->getByType($ph->type);
                }
                if ($placeholder) {
                    $this->_textLevelParaStyle = $placeholder->getTextLevelParaStyle();
                }
            }

            $override = TextLevelParaStyle::parseListStyle($this->_element->txBody?->lstStyle, $this->theme);
            if ($this->_textLevelParaStyle) {
                $this->_textLevelParaStyle = $this->_textLevelParaStyle->withStyles($override, $this->theme);
            } else {
                $this->_textLevelParaStyle = new TextLevelParaStyle($override, $this->theme);
            }
        }

        return $this->_textLevelParaStyle;
    }

    public function getLayoutPlaceholders(): LayoutPlaceholders
    {
        return $this->_parent->getLayoutPlaceholders();
    }

    public function getLineColor(): ?string
    {
        if (!$this->_sp->ln) {
            return null;
        }

        $fill = FillFormat::fromFillParent($this->_sp->ln);
        return $this->fillToColor($fill);
    }

    public function getLineStyle(): string
    {
        $ln = $this->_sp->ln;
        if (!$ln) {
            return '';
        }

        return $ln->prstDash?->val?->getHtmlValue();
    }

    public function getOutlineArr(): array
    {
        $arr = $this->getLine()->toArray();
        if ($arr['color']['type'] === 'color') {
            $arr['color'] = $arr['color']['color'];
        } elseif ($arr['color']['type'] === 'scheme') {
            $arr['color'] = $this->getSchemeColor($arr['color']['scheme']);
        }

        return $arr;
    }

    public function getTextArr(): ?array
    {
        $textFrame = $this->getTextFrame();
        if (!$textFrame) {
            return null;
        }

        $textType = null;
        if ($this->isPlaceholder) {
            $textType = $this->placeholderFormat->type;
            $textFrame->setMajor($textType->isMajor());
        }

        return array_merge([
            'type' => 'text',
            'content' => $textFrame->toHtml(),
            'defaultFontName' => $this->theme->getMajorFont(), // theme.fontName
            'defaultColor' => '', // theme.fontColor
            'lineHeight' => 1,
            'vertical' => $textFrame->isVertical,
            'textType' => $textType?->getTextType(),
            // lineHeight 行高
            // wordSpace 字间距
            // opacity 不透明度
            // shadow 阴影
            // paragraphSpace 段落间距
            // align 文本对齐方式
        ], $this->getFillArr());
    }

    /**
     * 形状
     * @return array
     */
    public function getGeometryArr(): array
    {
        if ($this->_sp->prstGeom) {
            return $this->getPrstGeomArray();
        }

        if ($this->_sp->getHasCustomGeometry()) {
            return $this->getCustomGeomArray();
        }

        return [];
    }

    private function getPrstGeomArray(): array
    {
        $shapeType = $this->_sp->prstGeom->prst->getXmlValue();
        if ($shapeType === 'line' || str_contains($shapeType, 'Connector')) {
            return $this->getLineArr();
        }

        return [
            'type' => 'shape',
            'shapeType' => $shapeType,
            'viewBox' => [200, 200],
            'points' => ['', $shapeType == MsoAutoShapeType::LINE_INVERSE->getXmlValue() ? 'arrow' : ''],
            'fill' => $this->getFillArr(),
            'path' => '',
        ];
    }

    private function getCustomGeomArray(): array
    {
        $custGeom = $this->_sp->spPr->custGeom;
        $pathList = [];
        $transform = $this->getTransform2D();
        $size = $transform->absSize;
        $viewBox = clone $size;
        if ($custGeom->pathLst) {
            $formula = new Formula();
            if ($custGeom->gdLst) {
                foreach ($custGeom->gdLst->gd_lst as $item) {
                    $formula->addGd($item->name, $item->fmla);
                }
            }

            foreach ($custGeom->pathLst->path_lst as $path) {
                $variables = [];
                if ($path->width) {
                    $variables['w'] = $path->width->emu;
                }
                if ($path->height) {
                    $variables['h'] = $path->height->emu;
                }
                $formula->setVariables($variables);

                $parseLength = function ($cmd) use ($formula) {
                    $v = $formula->execute($cmd);

                    return new Emu((int) $v);
                };

                $maxX = intval($path->width?->emu); // 此值实际是相对于当前的宽高
                $maxY = intval($path->height?->emu); // 此值实际是相对于当前的宽高
                $cX = $maxX === 0 ? 0 : $size->x / $maxX; // 换算比值
                $cY = $maxY === 0 ? 0 : $size->y / $maxY; // 换算比值
                $scale = new Point($cX, $cY);
                foreach ($path->contentChildren as $child) {
                    $cmd = $child->getCommand();
                    $ptLst = $child->getPtLst();

                    $offset = $transform->inheritOffset->scale(new Point(-1,-1));
                    $points = [];
                    foreach ($ptLst as $pt) {
                        $x = $pt->x;
                        $y = $pt->y;
                        if ($x->emu === 0 && !is_numeric($pt->fX)) {
                            $x = $parseLength($pt->fX);
                        }
                        if ($y->emu === 0 && !is_numeric($pt->fY)) {
                            $y = $parseLength($pt->fY);
                        }
                        $point = new Point($x->emu, $y->emu);
                        //$point = $point->rotate($transform->absRotation, $center);

                        $point->scale($scale);
                        // 应用上一级的偏移及旋转并减去偏移
                        $point = $transform->calInheritPoint($point)
                            ->move($offset);


                        $points[] = $point->lx->htmlVal . ',' . $point->ly->htmlVal;
                        if ($point->x > $viewBox->x) {
                            $viewBox->x = $point->x;
                        }
                        if ($point->y > $viewBox->y) {
                            $viewBox->y = $point->y;
                        }
                    }
                    $pathList[] = $cmd . implode(' ', $points);
                }
            }
        }

        if (($viewBox->x / $viewBox->y) > ($size->x / $size->y)) {
            $viewBox->x = $viewBox->y * $size->x / $size->y;
        } else {
            $viewBox->y = $viewBox->x * $size->y / $size->x;
        }

        return array_merge([
            'type' => 'shape',
            'special' => true,
            'path' => implode(' ', $pathList),
            'shadow' => $this->getShadowArr(),
            'viewBox' => [$viewBox->lx->htmlVal, $viewBox->ly->htmlVal],
            'fixedRatio' => false,
            'outline' => $this->getOutlineArr(),
            'lock' => false,
            'flipH' => $this->flipH,
            'flipV' => $this->flipV,
            'rotate' => $transform->rotation,
        ], $this->getFillArr());
    }

    public function getLineArr(): array
    {
        $data = parent::getLineArr();

        $outline = $this->getOutlineArr();
        $data['width'] = $outline['width'] ?: 1.33;
        $data['color'] = $outline['color'];
        $data['style'] = $outline['style'];

        return $data;
    }

    public function toArray(): array
    {
        $shape = $this->getGeometryArr();
        if (!empty($shape) && $shape['type'] == 'shape') {
            $text = $this->getTextArr();
            if ($text) {
                $shape['text'] = [
                    'content' => $text['content'],
                    'defaultFontName' => $text['defaultFontName'],
                    'defaultColor' => $text['defaultColor'],
                    'align' => $text['align'] ?? null,
                    'type' => $text['textType'] ?? '', // 'title' | 'subtitle' | 'content' | 'item' | 'itemTitle' | 'notes' | 'header' | 'footer' | 'partNumber' | 'itemNumber'
                ];
            }
        }
        if (empty($shape)) {
            $shape = array_merge($this->getTextArr(), $this->getSvgBox());
        }
        return array_merge(parent::toArray(),  $shape);
    }
}