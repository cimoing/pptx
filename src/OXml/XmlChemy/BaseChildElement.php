<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use DOMElement;
use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\OXml\Ns\NamespacePrefixedTag;
use Imoing\Pptx\OXml\Ns\NsMap;

abstract class BaseChildElement extends BaseObject
{
    /**
     * @var string
     */
    protected string $_namespaceTagName;

    /**
     * @var string[]
     */
    protected array $_successors = [];
    public function __construct(string $namespaceTagName, array $successors = [])
    {
        parent::__construct([]);
        $this->_namespaceTagName = $namespaceTagName;
        $this->_successors = $successors;
    }

    public static function create(string $namespaceTagName, array $successors = [])
    {
        return new static($namespaceTagName, $successors);
    }

    protected BaseOXmlElement $_elementCls;
    protected string $_propName;
    public function populateClassMembers(BaseOXmlElement $elementCls, string $propName, ...$args): void
    {
        $this->_elementCls = $elementCls;
        $this->_propName = $propName;
    }

    /**
     * 设置添加子元素的函数
     * @return void
     */
    protected function addAdder(): void
    {
        $func = function (BaseOXmlElement $elementObj, array $attrs = []): BaseOXmlElement {
            $newMethod = [$elementObj, $this->getNewMethodName()];

            /**
             * @var BaseOXmlElement $child
             */
            $child = call_user_func($newMethod);
            foreach ($attrs as $attrName => $attrValue) {
                $child->setAttribute($attrName, $attrValue);
            }

            $insertMethod = [$elementObj, $this->getInsertMethodName()];

            call_user_func($insertMethod, $child);

            return $child;
        };

        $this->addToClass($this->getAddMethodName(), $func);
    }

    protected function addCreator(): void
    {
        $this->addToClass($this->getNewMethodName(), $this->getCreator());
    }

    protected function addGetter(): void
    {
        $this->addToClass($this->getGetterMethodName(), $this->getGetter());
    }

    protected function addInserter(): void
    {
        $func = function (BaseOXmlElement $elementObj, BaseOXmlElement $child) {
            $elementObj->insertElementBefore($child, $this->_successors);
            return $child;
        };

        $this->addToClass($this->getInsertMethodName(), $func);
    }

    protected function addListGetter(): void
    {
        $propName = sprintf("%s_lst", $this->_propName);
        $func = function (BaseOXmlElement $obj): array {
            $ns = new NamespacePrefixedTag($this->_namespaceTagName);
            $items = $obj->getElementsByTagNameNS($ns->getNsUri(),$ns->getLocalPart());

            $result = [];
            foreach ($items as $item) {
                $result[] = NsMap::castDom($item);
            }
            return $result;
        };

        $this->_elementCls->setGetterSetter($propName, $func, null);
    }

    protected function getCreator(): callable
    {
        return function (BaseOXmlElement $obj): BaseOXmlElement {
            $nsTag = new NamespacePrefixedTag($this->_namespaceTagName);
            return makeOXmlElement($obj->ownerDocument, sprintf("<%s %s></%s>", $nsTag, nsdecls([$nsTag->getNspfx()]), $nsTag));
        };
    }

    protected function getGetter(): callable
    {
        return function (BaseOXmlElement $obj): ?BaseOXmlElement {
            $ns = new NamespacePrefixedTag($this->_namespaceTagName);
            $items = $obj->getElementsByTagNameNS($ns->getNsUri(),$ns->getLocalPart());
            return $items->count() > 0 ? NsMap::castDom($items->item(0)) : null;
        };
    }

    protected function addToClass(string $methodName, callable $fun): void
    {
        if ($this->_elementCls->hasCustomFunction($methodName)) {
            return;
        }
        $this->_elementCls->addCustomFunction($methodName, $fun);
    }

    protected function getAddMethodName(): string
    {
        return sprintf("_add_%s", $this->_propName);
    }

    protected function getInsertMethodName(): string
    {
        return sprintf("_insert_%s", $this->_propName);
    }

    protected function getNewMethodName(): string
    {
        return sprintf("_new_%s", $this->_propName);
    }

    protected function getGetterMethodName(): string
    {
        return sprintf('_get_%s', $this->_propName);
    }

    protected function getRemoveMethodName(): string
    {
        return sprintf('_remove_%s', $this->_propName);
    }
}