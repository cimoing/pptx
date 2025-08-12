<?php

namespace Imoing\Pptx\Shapes\AutoShape;

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
        return $this->_parent->getSchemeColor($scheme);
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
            $this->_line = new LineFormat($this);
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

        $textType = '';
        if ($this->isPlaceholder) {
            $textType = $this->placeholderFormat->type->getHtmlValue();
        }

        return array_merge([
            'type' => 'text',
            'content' => $textFrame->toHtml(),
            'defaultFontName' => '', // theme.fontName
            'defaultColor' => '', // theme.fontColor
            'lineHeight' => 1,
            'vertical' => $textFrame->isVertical,
            //'textType' => $textType,
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
        ];
    }

    private function getCustomGeomArray(): array
    {
        $custGeom = $this->_sp->spPr->custGeom;
        $pathList = [];
        $w = $this->getWidth();
        $h = $this->getHeight();
        $viewBox = [$w->pt,$h->pt];
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
                $cX = $maxX === 0 ? 0 : $w->pt / $maxX; // 换算比值
                $cY = $maxY === 0 ? 0 : $h->pt / $maxY; // 换算比值
                foreach ($path->contentChildren as $child) {
                    $cmd = $child->getCommand();
                    $ptLst = $child->getPtLst();

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
                        $points[] = $x->emu * $cX . ',' . $y->emu * $cY;
                        $viewBox[0] = max($viewBox[0], $x->emu * $cX);
                        $viewBox[1] = max($viewBox[1], $y->emu * $cY);
                    }
                    $pathList[] = $cmd . implode(' ', $points);
                }
            }
        }

        return array_merge([
            'type' => 'shape',
            'special' => true,
            'path' => implode(' ', $pathList),
            'shadow' => $this->getShadowArr(),
            'viewBox' => $viewBox,
            'fixedRatio' => false,
            'outline' => $this->getOutlineArr(),
            'lock' => false,
        ], $this->getFillArr());
    }

    public function getLineArr(): array
    {
        $shapeType = $this->_sp->prstGeom->prst->getXmlValue();
        $start = $end = [0, 0];
        $isFlipV = $this->flipV;
        $isFlipH = $this->flipH;
        $width = $this->getWidth()->px;
        $height = $this->getHeight()->px;
        if (!$isFlipV && !$isFlipH) {
            $end = [$width, $height];
        } else if ($isFlipV && $isFlipH) {
            $start = [$width, $height];
        } else if ($isFlipV && !$isFlipH) {
            $start = [0, $height];
            $end = [$width, 0];
        } else {
            $start = [$width, 0];
            $end = [0, $height];
        }

        $rot = $this->rotation;

        $outline = $this->getOutlineArr();
        $data = [
            'width' => $width ?: 1,
            'type' => 'line',
            'start' => $start,
            'end' => $end,
            'color' => $outline['color'],
            'style' => $outline['style'],
            'points' => ['', $shapeType == MsoAutoShapeType::LINE_INVERSE->getXmlValue() ? 'arrow' : ''],
        ];
        if ($rot != 0) {
            $data = $this->rotateLine($data, $rot);
        }

        if (str_contains($shapeType, 'bentConnector')) {
            $data['broken2'] = [
                abs(($data['start'][0] - $data['end'][0]) / 2),
                abs(($data['start'][1] - $data['end'][1]) / 2)
            ];
        }

        if (str_contains($shapeType, 'curvedConnector')) {
            $cubic = [
                abs(($data['start'][0] - $data['end'][0]) / 2),
                abs(($data['start'][1] - $data['end'][1]) / 2)
            ];
            $data['cubic'] = [$cubic, $cubic];
        }

        return $data;
    }

    private function rotateLine(array $data, $angleDeg): array
    {
        $start = $data['start'];

        $end = $data['end'];


        $angleRad = $angleDeg * M_PI / 180;


        $midX = ($start[0] + $end[0]) / 2;
        $midY = ($start[1] + $end[1]) / 2;

        $startTransX = $start[0] - $midX;
        $startTransY = $start[1] - $midY;
        $endTransX = $end[0] - $midX;
        $endTransY = $end[1] - $midY;

        $cosA = cos($angleRad);
        $sinA = sin($angleRad);

        $startRotX = $startTransX * $cosA - $startTransY * $sinA;
        $startRotY = $startTransX * $sinA + $startTransY * $cosA;

        $endRotX = $endTransX * $cosA - $endTransY * $sinA;
        $endRotY = $endTransX * $sinA + $endTransY * $cosA;

        $startNewX = $startRotX + $midX;
        $startNewY = $startRotY + $midY;
        $endNewX = $endRotX + $midX;
        $endNewY = $endRotY + $midY;

        $beforeMinX = min($start[0], $end[0]);
        $beforeMinY = min($start[1], $end[1]);

        $afterMinX = min($startNewX, $endNewX);
        $afterMinY = min($startNewY, $endNewY);

        $startAdjustedX = $startNewX - $afterMinX;
        $startAdjustedY = $startNewY - $afterMinY;
        $endAdjustedX = $endNewX - $afterMinX;
        $endAdjustedY = $endNewY - $afterMinY;

        $startAdjusted = [$startAdjustedX, $startAdjustedY];
        $endAdjusted = [$endAdjustedX, $endAdjustedY];
        $offset = [$afterMinX - $beforeMinX, $afterMinY - $beforeMinY];

        $data['start'] = $startAdjusted;
        $data['end'] = $endAdjusted;
        $data['left'] += $offset[0];
        $data['top'] += $offset[1];

        return $data;
    }

    public function toArray(): array
    {
        $shape = $this->getGeometryArr();
        if (!empty($shape) && $shape['type'] == 'shape') {
            $shapeType = $shape['shapeType'] ?? '';
            $text = $this->getTextArr();
            if ($shapeType === 'rect' && $text) {
                $shape = $text;
            }else if ($text) {
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
            $shape = $this->getTextArr();
        }
        return array_merge(parent::toArray(),  $shape);
    }
}