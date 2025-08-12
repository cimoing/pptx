<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\SimpleTypes\XsdBoolean;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTTextCharacterProperties get_or_add_rPr()
 * @property BaseOXmlElement $t
 * @property ?CTTextCharacterProperties $rPr
 * @property string $text
 */
class CTRegularTextRun extends BaseOXmlElement
{
    #[ZeroOrOne("a:rPr", successors: ["a:t"])]
    protected ?CTTextCharacterProperties $_rPr;

    #[OneAndOnlyOne("a:t")]
    protected BaseOXmlElement $_t;

    public function getText(): string
    {
        return $this->t->textContent ?: '';
    }

    public function setText(string $text): void
    {
        $text = self::_escape_ctrl_chars($text);
        $this->t->textContent = $text;
    }

    private static function _escape_ctrl_chars(string $str): string
    {
        return preg_replace_callback(
            '/[\x00-\x08\x0B-\x1F]/',
            function($match) {
                return '_x' . strtoupper(str_pad(dechex(ord($match[0])), 4, '0', STR_PAD_LEFT) . '_');
            },
            $str
        );
    }

    public function getHtmlText(): string
    {
        return $this->rPr?->b ? "<strong>{$this->getText()}</strong>" : $this->getText();
    }
}