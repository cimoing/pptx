<?php

namespace Imoing\Pptx\Parts;

use Imoing\Pptx\IPackage;

interface ICorePropertiesPart
{
    public static function default(IPackage $package): ICorePropertiesPart;
    public function getAuthor(): string;
    public function setAuthor(string $pValue): void;

    public function getCategory(): string;
    public function setCategory(string $pValue): void;

    public function getComments(): string;
    public function setComments(string $pValue): void;

    public function getContentStatus(): string;
    public function setContentStatus(string $pValue): void;

    public function getCreated(): ?\DateTime;
    public function setCreated(\DateTime $pValue): void;

    public function getIdentifier(): string;
    public function setIdentifier(string $pValue): void;

    public function getKeywords(): string;
    public function setKeywords(string $pValue): void;

    public function getLanguage(): string;
    public function setLanguage(string $pValue): void;

    public function getLastModifiedBy(): string;
    public function setLastModifiedBy(string $pValue): void;

    public function getLastPrinted(): ?\DateTime;
    public function setLastPrinted(\DateTime $pValue): void;

    public function getModified(): ?\DateTime;
    public function setModified(\DateTime $pValue): void;

    public function getRevision(): ?int;
    public function setRevision(int $pValue): void;

    public function getSubject(): string;
    public function setSubject(string $pValue): void;

    public function getTitle(): string;
    public function setTitle(string $pValue): void;

    public function getVersion(): string;
    public function setVersion(string $pValue): void;
}