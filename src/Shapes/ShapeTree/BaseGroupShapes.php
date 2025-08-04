<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\MsoConnectorType;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnector;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\Shapes\Pictures\CTPicture;
use Imoing\Pptx\Parts\Image\ImagePart;
use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Connector;
use Imoing\Pptx\Shapes\GroupShape;
use Imoing\Pptx\Shapes\Picture\Picture;
use Imoing\Pptx\Types\ProvidesPart;
use Imoing\Pptx\Util\Length;

/**
 * @property CTGroupShape $_element
 * @property SlidePart $part
 */
abstract class BaseGroupShapes extends BaseShapes
{
    protected CTGroupShape $_grpSp;
    public function __construct(CTGroupShape $groupShape, ProvidesPart $parent)
    {
        parent::__construct($groupShape, $parent);
        $this->_grpSp = $groupShape;
    }

    //TODO add_chart

    public function addConnector(MsoConnectorType $connectorType, Length $beginX, Length $beginY, Length $endX, Length $endY): Connector
    {
        $shape = $this->_addCxnSp($connectorType, $beginX, $beginY, $endX, $endY);
        $this->recalculateExtents();
        $obj = $this->shapeFactory($shape);
        assert($obj instanceof Connector);

        return $obj;
    }

    public function addGroupShape(array $shapes): GroupShape
    {
        $shape = $this->_element->add_grpSp();
        foreach ($shapes as $child) {
            $shape->insertElementBefore($child->getElement(), ["p:extLst"]);
        }

        if (!empty($shapes)) {
            $this->recalculateExtents();
        }

        $obj = $this->shapeFactory($shape);
        assert($obj instanceof GroupShape);
        return $obj;
    }

    //TODO add_ole_object

    public function addImage(string $imageFile, Length $left, Length $top, ?Length $width, ?Length $height): Picture
    {
        list($imagePart, $rId) = $this->part->getOrAddImagePart($imageFile);
        $pic = $this->_addPicFromImagePart($imagePart, $rId,$left, $top, $width, $height);
        $this->recalculateExtents();
        $obj = $this->shapeFactory($pic);
        assert($obj instanceof Picture);
        return $obj;
    }

    /**
     * Return new |Shape| object appended to this shape tree.
     *
     * `autoshape_type_id` is a member of :ref:`MsoAutoShapeType` e.g. `MSO_SHAPE.RECTANGLE`
     * specifying the type of shape to be added. The remaining arguments specify the new shape's
     * position and size.
     * @param MsoAutoShapeType $shapeType
     * @param Length $left
     * @param Length $top
     * @param Length $width
     * @param Length $height
     * @return Shape
     */
    public function addShape(MsoAutoShapeType $shapeType, Length $left, Length $top, Length $width, Length $height): Shape
    {
        $shape = $this->_addSp($shapeType, $left, $top, $width, $height);
        $this->recalculateExtents();
        $obj = $this->shapeFactory($shape);
        assert($obj instanceof Shape);
        return $obj;
    }

    public function addTextbox(Length $left, Length $top, Length $width, Length $height): Shape
    {
        $shape = $this->_addTextBoxSp($left, $top, $width, $height);
        $this->recalculateExtents();
        $obj = $this->shapeFactory($shape);
        assert($obj instanceof Shape);
        return $obj;
    }

    /**
     * Return the index of `shape` in this sequence.
     *
     * Raises |ValueError| if `shape` is not in the collection.
     * @param BaseShape $shape
     * @return int
     */
    public function index(BaseShape $shape): int
    {
        $shapeElms = iterator_to_array($this->_element->iter_shape_elms());
        return array_search($shape, $shapeElms, true);
    }

    //TODO _add_chart_graphicFrame

    protected function _addCxnSp(MsoConnectorType $connectorType, Length $beginX, Length $beginY, Length $endX, Length $endY): CTConnector
    {
        $id = $this->getNextShapeId();
        $name = sprintf("Connector %d", $id - 1);
        list($flipH, $flipV) = [$beginX->getEmu() > $endX->getEmu(), $beginY->getEmu() > $endY->getEmu()];
        list($x, $y) = [min($beginX->getEmu(),$endX->getEmu()), min($beginY->getEmu(),$endY->getEmu())];
        list($cx, $cy) = [abs($endX->getEmu() - $beginX->getEmu()),abs($endY->getEmu() - $beginY->getEmu())];

        return $this->_element->add_cxnSp($id, $name, $connectorType, $x, $y, $cx, $cy, $flipH, $flipV);
    }

    protected function _addPicFromImagePart(ImagePart $imagePart, string $rId, Length $x, Length $y, ?Length $cx, ?Length $cy): CTPicture
    {
        $id = $this->getNextShapeId();
        list($scaledCx, $scaledCy) = $imagePart->scale($cx, $cy);
        $name = sprintf("Picture %d", $id - 1);
        $desc = $imagePart->desc;
        return $this->_grpSp->add_pic($id, $name, $desc, $rId, $x->getEmu(), $y->getEmu(), $scaledCx, $scaledCy);
    }

    protected function _addSp(MsoAutoShapeType $autoShapeType, Length $x, Length $y, Length $cx, Length $cy): CTShape
    {
        $id = $this->getNextShapeId();
        $name = sprintf("%s %d", $autoShapeType->getXmlValue(), $id - 1);
        return $this->_grpSp->add_autoshape($id, $name, $autoShapeType->getXmlValue(), $x->getEmu(), $y->getEmu(), $cx->getEmu(), $cy->getEmu());
    }
    protected function _addTextBoxSp(Length $x, Length $y, Length $cx, Length $cy): CTShape
    {
        $id = $this->getNextShapeId();
        $name = sprintf("TextBox %d", $id - 1);
        return $this->_spTree->add_textbox($id, $name, $x->getEmu(), $y->getEmu(), $cx->getEmu(), $cy->getEmu());
    }
    /**
     * Adjust position and size to incorporate all contained shapes.
     *
     * This would typically be called when a contained shape is added, removed, or its position
     * or size updated.
     * @return void
     */
    protected function recalculateExtents(): void
    {
        // do nothing
    }
}