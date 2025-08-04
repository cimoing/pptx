<?php

namespace Imoing\Pptx\OXml\XmlChemy;

class Choice extends BaseChildElement
{
    public function getNamespaceTagName(): string
    {
        return $this->_namespaceTagName;
    }

    protected string $_groupPropName;
    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        $successors = $args[0];
        $this->_elementCls = $elementCls;
        $this->_groupPropName = $propName;
        $this->_successors = $successors;

        $this->addGetter();
        $this->addCreator();
        $this->addInserter();
        $this->addAdder();
    }

    protected function addGetOrChangeToMethod(): void
    {
        $func = function (BaseOXmlElement $elementObj): BaseOXmlElement {
            $propName = $this->getPropName();
            $child = isset($elementObj[$propName]) ? $elementObj->{$propName} : null;
            if ($child !== null) {
                return $child;
            }

            $removeMethod = [$elementObj, $this->getRemoveMethodName()];
            call_user_func($removeMethod);

            $addMethod = [$elementObj, $this->getAddMethodName()];
            return call_user_func($addMethod);
        };

        $this->addToClass($this->getGetOrChangeToMethodName(), $func);
    }

    protected function getPropName(): string
    {
        $pos = strpos($this->_namespaceTagName, ":");
        if ($pos === false) {
            $pos = 0;
        } else {
            $pos += 1;
        }

        return substr($this->_namespaceTagName, $pos - strlen($this->_namespaceTagName));
    }

    protected function getGetOrChangeToMethodName(): string
    {
        return sprintf('get_or_change_to_%s', $this->getPropName());
    }

    protected function getRemoveGroupMethodName(): string
    {
        return sprintf('remove_%s', $this->_groupPropName);
    }
}