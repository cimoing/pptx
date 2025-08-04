<?php

namespace Imoing\Pptx\OXml\CoreProps;

use DateTime;
use DOMElement;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method BaseOXmlElement get_or_add_revision()
 * @property BaseOXmlElement $revision
 * @property string $authorText
 * @property string $categoryText
 * @property string $commentText
 * @property string $contentStatusText
 * @property ?DateTime $createdDateTime
 * @property string $identifierText
 * @property string $keywordsText
 * @property string $languageText
 * @property string $lastModifiedByText
 * @property ?DateTime $lastPrintedDateTime
 * @property ?DateTime $modifiedDateTime
 * @property int $revisionNumber
 * @property string $subjectText
 * @property string $titleText
 * @property string $versionText
 */
class CTCoreProperties extends BaseOXmlElement
{
    #[ZeroOrOne("cp:category", successors: [])]
    protected mixed $_category;

    #[ZeroOrOne("cp:contentStatus", successors: [])]
    protected mixed $_contentStatus;

    #[ZeroOrOne("dcterms:created", successors: [])]
    protected mixed $_created;

    #[ZeroOrOne("dc:creator", successors: [])]
    protected mixed $_creator;

    #[ZeroOrOne("dc:description", successors: [])]
    protected mixed $_description;

    #[ZeroOrOne("dc:identifier", successors: [])]
    protected mixed $_identifier;

    #[ZeroOrOne("cp:keywords", successors: [])]
    protected mixed $_keywords;

    #[ZeroOrOne("dc:language", successors: [])]
    protected mixed $_language;

    #[ZeroOrOne("cp:lastModifiedBy", successors: [])]
    protected mixed $_lastModifiedBy;

    #[ZeroOrOne("cp:lastPrinted", successors: [])]
    protected mixed $_lastPrinted;

    #[ZeroOrOne("dcterms:modified", successors: [])]
    protected mixed $_modified;

    #[ZeroOrOne("cp:revision", successors: [])]
    protected ?DOMElement $_revision;

    #[ZeroOrOne("dc:subject", successors: [])]
    protected mixed $_subject;

    #[ZeroOrOne("dc:title", successors: [])]
    protected mixed $_title;

    #[ZeroOrOne("cp:version", successors: [])]
    protected mixed $_version;

    /**
     * @return static
     */
    public static function create(): static
    {
        $xml = sprintf("<cp:coreProperties %s/>", nsdecls(["cp", "dc", "dcterms"]));

        $dom = new \DOMDocument('1.0', 'utf-8');
        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof self);

        return $obj;
    }

    public function getAuthorText(): string
    {
        return $this->getTextOfElement("creator");
    }

    public function setAuthorText(string $value): void
    {
        $this->setElementText("creator", $value);
    }

    public function getCategoryText(): string
    {
        return $this->getTextOfElement("category");
    }

    public function setCategoryText(string $value): void
    {
        $this->setElementText("category", $value);
    }

    public function getCommentText(): string
    {
        return $this->getTextOfElement("comment");
    }

    public function setCommentText(string $value): void
    {
        $this->setElementText("comment", $value);
    }

    public function getContentStatusText(): string
    {
        return $this->getTextOfElement("contentStatus");
    }

    public function setContentStatusText(string $value): void
    {
        $this->setElementText("contentStatus", $value);
    }

    public function getCreatedDateTime(): ?DateTime
    {
        return $this->getDatetimeOfElement("created");
    }

    public function setCreatedDateTime(?DateTime $datetime): void
    {
        $this->setDatetimeOfElement("created", $datetime);
    }

    public function getIdentifierText(): string
    {
        return $this->getTextOfElement("identifier");
    }

    public function setIdentifierText(string $value): void
    {
        $this->setElementText("identifier", $value);
    }

    protected function getKeywordsText(): string
    {
        return $this->getTextOfElement("keywords");
    }
    protected function setKeywordsText(string $value): void
    {
        $this->setElementText("keywords", $value);
    }

    protected function getLanguageText(): string
    {
        return $this->getTextOfElement("language");
    }
    protected function setLanguageText(string $value): void
    {
        $this->setElementText("language", $value);
    }

    protected function getLastModifiedByText(): string
    {
        return $this->getTextOfElement("lastModifiedBy");
    }

    protected function setLastModifiedByText(string $value): void
    {
        $this->setElementText("lastModifiedBy", $value);
    }

    protected function getLastPrintedDateTime(): ?DateTime
    {
        return $this->getDatetimeOfElement("lastPrinted");
    }

    protected function setLastPrintedDateTime(?DateTime $datetime): void
    {
        $this->setDatetimeOfElement("lastPrinted", $datetime);
    }

    protected function getModifiedDateTime(): ?DateTime
    {
        return $this->getDatetimeOfElement("modified");
    }
    protected function setModifiedDateTime(?DateTime $datetime): void
    {
        $this->setDatetimeOfElement("modified", $datetime);
    }

    protected function getRevisionNumber(): int
    {
        $revision = $this->revision;
        if (empty($revision)) {
            return 0;
        }

        $txt = $revision->textContent;

        $num = intval($txt);
        if ($num < 0) {
            $num = 0;
        }

        return $num;
    }

    protected function setRevisionNumber(int $value): void
    {
        $element = $this->get_or_add_revision();
        $element->textContent = $value;
    }

    protected function getSubjectText(): string
    {
        return $this->getTextOfElement("subject");
    }

    protected function setSubjectText(string $value): void
    {
        $this->setElementText("subject", $value);
    }

    protected function getTitleText(): string
    {
        return $this->getTextOfElement("title");
    }
    protected function setTitleText(string $value): void
    {
        $this->setElementText("title", $value);
    }

    protected function getVersionText(): string
    {
        return $this->getTextOfElement("version");
    }
    protected function setVersionText(string $value): void
    {
        $this->setElementText("version", $value);
    }

    protected function setElementText(string $propertyName, string $value): void
    {
        if (strlen($value) > 255) {
            throw new \Exception("exceeded 255 char limit for property, got:\n\n'{$value}'");
        }

        $element = $this->_get_or_add($propertyName);
        $element->textContent = $value;
    }

    protected function getTextOfElement(string $propertyName): string
    {
        $element = $this->$propertyName;
        if ($element === null) {
            return "";
        }

        if ($element->textContent !== null) {
            return $element->textContent;
        }

        return "";
    }

    private function getDatetimeOfElement(string $propertyName): ?\DateTime
    {
        $element = $this->$propertyName;
        if ($element === null) {
            return null;
        }

        $str = $element->textContent;
        if (empty($str)) {
            return null;
        }

        return new \DateTime($str);
    }

    private function setDateTimeOfElement(string $propertyName, DateTime $datetime): void
    {
        $element = $this->_get_or_add($propertyName);
        $str = $datetime->format("%Y-%m-%dT%H:%M:%SZ");
        $element->textContent = $str;
        if (in_array($propertyName, ["created", "modified"])) {
            $this->setAttribute("xsi:foo", "bar");
            $element->setAttribute("xsi:type", "dcterms:W3CDTF");
            $this->removeAttribute("xsi:foo");
        }
    }

    /**
     * @param string $propName
     * @return DOMElement|mixed
     */
    protected function _get_or_add(string $propName)
    {
        $method = sprintf("get_or_add_%s", $propName);
        return $this->$method();
    }
}