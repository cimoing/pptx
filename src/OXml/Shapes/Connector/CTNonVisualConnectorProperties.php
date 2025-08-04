<?php

namespace Imoing\Pptx\OXml\Shapes\Connector;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * tag sequences: "a:cxnSpLocks", "a:stCxn", "a:endCxn", "a:extLst"
 */
class CTNonVisualConnectorProperties extends BaseOXmlElement
{
    #[ZeroOrOne("a:stCxn", successors: ["a:endCxn", "a:extLst"])]
    protected mixed $stCxn;

    #[ZeroOrOne("a:endCxn", successors: ["a:extLst"])]
    protected mixed $endCxn;
}