<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;

class CTTimeNodeList extends BaseOXmlElement
{
    public function add_video(int $shapeId)
    {
        $xml = sprintf('<p:video %s>
    <p:cMediaNode vol="80000">
        <p:cTn id="%d" fill="hold" display="0">
            <p:stCondLst>
                <p:cond delay="indefinite"/>
            </p:stCondLst>
        </p:cTn>
        <p:tgtEl>
            <p:spTgt spid="%d" />
        </p:tgtEl>
    </p:cMediaNode>
</p:video>', nsdecls("p"), $this->getNextCtnId(), $shapeId);
    }

    private function getNextCtnId()
    {
        $children = $this->getElementsByNsTagName("p:cTn");
        $maxId = 0;
        foreach ($children as $child) {
            if ($maxId < $child->getAttribute("id")) {
                $maxId = $child->getAttribute("id");
            }
        }

        return $maxId+1;
    }
}