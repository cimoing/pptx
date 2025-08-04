<?php

namespace Imoing\Pptx\OXml\Presentation;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property-read CTSlideId[] $sldId_lst
 * @method CTSlideId _add_sldId( array $attributes)
 */
class CTSlideIdList extends BaseOXmlElement
{
    #[ZeroOrMore("p:sldId")]
    protected array $_sldId;

    /**
     * 添加sldId，暴露对应方法
     * @param string $relationId
     * @return CTSlideId
     */
    public function add_sldId(string $relationId): CTSlideId
    {
        return $this->_add_sldId(['id' => $this->getNextId(), 'r:id' => $relationId]);
    }

    private function getNextId(): int
    {
        $minId = 256;
        $maxId = 2147483647;
        $usedIds = [];
        $items = $this->getDirectChildrenByNsTagName('p:sldId');
        foreach ($items as $item) {
            $usedIds[] = (int) $item->getAttribute("id");
        }

        $simpleNext  = max(array_merge([$maxId-1], $usedIds)) + 1;
        if ($simpleNext <= $maxId) {
            return $simpleNext;
        }

        $usedIds = array_filter($usedIds, function ($id) use ($minId, $maxId) {
            return $minId <= $id && $id <= $maxId;
        });
        sort($usedIds, SORT_ASC|SORT_NUMERIC);

        if (empty($usedIds)) {
            return $minId;
        }

        $idx = 0;
        for ($i = $minId; $i <= $maxId; $i++) {
            if ($i != ($usedIds[$idx] ?? -1)) {
                return $i;
            }
            $idx++;
        }

        return $maxId;
    }
}