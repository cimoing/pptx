<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Imoing\Pptx\OXml\Ns\NsMap;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ZeroOrOneChoice extends BaseChildElement
{
    /**
     * @var Choice[]
     */
    protected array $_choices = [];

    protected array $_successors = [];

    /**
     * @param Choice[] $choices
     * @param array $successors
     */
    public function __construct(array $choices, array $successors = [])
    {
        parent::__construct('', []);
        $this->_choices = $choices;
        $this->_successors = $successors;
    }

    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        parent::populateClassMembers($elementCls, $propName, $args);
        $this->addChoiceGetter();
        foreach ($this->_choices as $choice) {
            $choice->populateClassMembers($elementCls, $propName, $args);
        }
        $this->addGroupRemover();
    }

    private function addChoiceGetter(): void
    {
        $func = function (BaseOXmlElement $element): ?BaseOXmlElement {
            $node = $element->firstChildFoundIn($this->getMemberNsTagNames());
            if (empty($node)) {
                return null;
            }

            return $node;
        };
        $this->_elementCls->setGetterSetter($this->_propName, $func, null);
    }

    private function getMemberNsTagNames(): array
    {
        return array_map(function (Choice $choice) {
            return $choice->getNamespaceTagName();
        }, $this->_choices);
    }

    private function addGroupRemover(): void
    {
        $func = function (BaseOXmlElement $element): void {
            $tagNames = $this->getMemberNsTagNames();
            while(true) {
                $node = $element->firstChildFoundIn($tagNames);
                if (empty($node)) {
                    break;
                }
                $element->removeChild($node->element);
            }
        };

        $this->addToClass($this->getRemoveChoiceGroupMethodNames(), $func);
    }

    private function getRemoveChoiceGroupMethodNames(): string
    {
        return sprintf("_remove_%s", $this->_propName);
    }
}