<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @see       https://github.com/zendframework/zend-view for the canonical source repository
 * @author    Marcel Notbohm <marcel@notbohm.com>
 * @copyright Copyright (c) 2015-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive/blob/master/LICENSE.md New BSD License
 */

namespace Zend\View\Helper;

/**
 * Class Video
 * @package Zend\View\Helper
 */
class Video extends AbstractHtmlElement
{
    const NOT_SUPPORT = 'Your browser does not support the HTML5 video tag.';

    /**
     * @var
     */
    protected $attribs;

    /**
     * @var
     */
    protected $sources;

    /**
     * @param string|array $source
     * @param array $attribs
     * @return string
     */
    public function __invoke($source, $attribs = [])
    {
        if (is_string($source)) {
            $attribs = array_merge(['src' => $source], $attribs);
        }
        if (!empty($attribs)) {
            $this->setAttribs($attribs);
        }
        if (is_array($source)) {
            $this->setSources($source);
        }

        return $this->htmlVideoTag();
    }

    /**
     * Get complete rendering video tag
     *
     * @return string
     */
    public function htmlVideoTag()
    {
        return $this->openTag() .
            $this->sourcesTags($this->getSources()) .
            self::NOT_SUPPORT .
            $this->closeTag();
    }

    /**
     * Render video opening tag
     *
     * @return string
     */
    public function openTag()
    {
        return '<video' . $this->htmlAttribs($this->getAttribs()) . '>';
    }

    /**
     * Render video close tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</video>';
    }

    /**
     * Get complete sources tags within video tag
     *
     * @param array $sources
     * @return string
     */
    public function sourcesTags($sources)
    {
        $sourceTag = '';

        foreach ((array)$sources as $key => $val) {

            if (isset($val['src']) AND isset($val['type'])) {
                $sourceTag .= '<source' . $this->htmlAttribs($val) . '>';
            }

        }

        return $sourceTag;
    }

    /**
     * Overwrite the htmlAttribs() in parent class
     * Converts an associative array to a string of tag attributes.
     *
     * @param array $attribs
     * @return string The XHTML or HTML5 for the attributes.
     */
    protected function htmlAttribs($attribs)
    {
        $attribsString = '';
        $escaper = $this->getView()->plugin('escapehtml');
        $escapeHtmlAttr = $this->getView()->plugin('escapehtmlattr');

        foreach ((array)$attribs as $key => $val) {

            $key = $escaper($key);
            $val = $escapeHtmlAttr($val);

            if ('id' == $key) {
                $val = $this->normalizeId($val);
            }

            if (in_array($key, ['controls', 'muted', 'loop', 'autoplay'])) {
                $val = $key;
            }

            if (($this->isHtml5()) AND ($val === $key)) {
                $attribsString .= " " . $val;
            } else {

                if (strpos($val, '"') !== false) {
                    $attribsString .= " $key='$val'";
                } else {
                    $attribsString .= " $key=\"$val\"";
                }

            }

        }

        return $attribsString;
    }

    /**
     * Is doctype HTML5?
     *
     * @return bool
     */
    protected function isHtml5()
    {
        return $this->getView()->plugin('doctype')->isHtml5();
    }

    /**
     * Set sources within video tag
     *
     * @param array $sources
     * @return Video
     */
    public function setSources(array $sources)
    {
        $this->sources = $sources;
        return $this;
    }

    /**
     * Get sources within video tag
     *
     * @return mixed
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Set attribs for video tag
     *
     * @param array $attribs
     * @return Video
     */
    public function setAttribs(array $attribs)
    {
        $this->attribs = $attribs;
        return $this;
    }

    /**
     * Get attribs for video tag
     *
     * @return mixed
     */
    public function getAttribs()
    {
        return $this->attribs;
    }
}