<?php

namespace Imoing\Pptx\Parts\CoreProps;

use DateTime;
use Imoing\Pptx\Opc\Constants\ContentType;
use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\Opc\XmlPart;
use Imoing\Pptx\OXml\CoreProps\CTCoreProperties;
use Imoing\Pptx\Package\Package;

/**
 * @property CTCoreProperties $_element;
 * @property string $title
 * @property string $subject
 * @property string $lastModifiedBy
 * @property int $revision
 * @property ?DateTime $modified
 * @property ?DateTime $created
 * @property string $contentStatus
 * @property string $comments
 * @property string $category
 * @property string $author
 */
class CorePropertiesPart extends XmlPart
{
    public static string $nsTag = 'cp:coreProperties';

    public static function default(Package $package): static
    {
        $obj = self::_create($package);
        $obj->title = "PowerPoint Presentation";
        $obj->lastModifiedBy = "php-pptx";
        $obj->revision = 1;
        $obj->modified = new DateTime();
        return $obj;
    }

    public function getContentStatus(): string
    {
        return $this->_element->contentStatusText;
    }

    public function setContentStatus(string $contentStatus): void
    {
        $this->_element->contentStatusText = $contentStatus;
    }

    public function getComments(): string
    {
        return $this->_element->commentText;
    }

    public function setComments(string $comments): void
    {
        $this->_element->commentText = $comments;
    }

    public function getCategory(): string
    {
        return $this->_element->categoryText;
    }

    public function setCategory(string $category): void
    {
        $this->_element->categoryText = $category;
    }

    public function getAuthor(): string
    {
        return $this->_element->authorText;
    }

    public function setAuthor(string $author): void
    {
        $this->_element->authorText = $author;
    }



    protected function getIdentifier(): string
    {
        return $this->_element->identifierText;
    }

    protected function setIdentifier(string $identifier): void
    {
        $this->_element->identifierText = $identifier;
    }

    protected function getKeywords(): string
    {
        return $this->_element->keywordsText;
    }

    protected function setKeywords(string $keywords): void
    {
        $this->_element->keywordsText = $keywords;
    }

    protected function getLanguage(): string
    {
        return $this->_element->languageText;
    }

    protected function setLanguage(string $language): void
    {
        $this->_element->languageText = $language;
    }

    protected function getLastModifiedBy(): string
    {
        return $this->_element->lastModifiedByText;
    }

    protected function setLastModifiedBy(string $lastModifiedBy): void
    {
        $this->_element->lastModifiedByText = $lastModifiedBy;
    }

    protected function getLastPrinted(): ?DateTime
    {
        return $this->_element->lastPrintedDateTime;
    }

    protected function setLastPrinted(?DateTime $lastPrinted): void
    {
        $this->_element->lastPrintedDateTime = $lastPrinted;
    }

    protected function getCreated(): ?DateTime
    {
        return $this->_element->createdDateTime;
    }

    protected function setCreated(?DateTime $dateTime): void
    {
        $this->_element->setCreatedDateTime($dateTime);
    }

    protected function getModified(): ?DateTime
    {
        return $this->_element->modifiedDateTime;
    }

    protected function setModified(?DateTime $dateTime): void
    {
        $this->_element->modifiedDateTime = $dateTime;
    }

    protected function getRevision(): int
    {
        return $this->_element->revisionNumber;
    }

    protected function setRevision(int $revision): void
    {
        $this->_element->revisionNumber = $revision;
    }

    protected function getSubject(): string
    {
        return $this->_element->subjectText;
    }

    protected function setSubject(string $value): void
    {
        $this->_element->subjectText = $value;
    }

    protected function getTitle(): string
    {
        return $this->_element->titleText;
    }

    protected function setTitle(string $title): void
    {
        $this->_element->titleText = $title;
    }

    protected function getVersion(): string
    {
        return $this->_element->versionText;
    }

    protected function setVersion(string $version)
    {
        $this->_element->versionText = $version;
    }
    private static function _create(Package $package): static
    {
        return new CorePropertiesPart(new PackURI("/docProps/core.xml"), ContentType::OPC_CORE_PROPERTIES, $package, CTCoreProperties::create());
    }
}