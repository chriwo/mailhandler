<?php
declare(strict_types=1);
namespace ChriWo\Mailhandler\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class StringUtility.
 */
class StringUtility
{
    /**
     * Parse String with Fluid View.
     *
     * @param string $string Any string
     * @param array $variables Variables
     * @param string $format Default value is 'html'
     * @return string Parsed string
     */
    public static function fluidParseString(string $string, array $variables = [], string $format = 'html'): string
    {
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $parseObject */
        $parseObject = GeneralUtility::makeInstance(ObjectManager::class)->get(StandaloneView::class);
        $parseObject->setTemplateSource($string);
        $parseObject->setFormat($format);
        $parseObject->assignMultiple($variables);

        return $parseObject->render();
    }

    /**
     * Function makePlain() removes html tags and add linebreaks
     *        Easy generate a plain email bodytext from a html bodytext.
     *
     * @param string $content HTML Mail bodytext
     * @return string $content
     */
    public static function makePlain(string $content): string
    {
        $tags2LineBreaks = [
            '</p>',
            '</tr>',
            '<ul>',
            '</li>',
            '</h1>',
            '</h2>',
            '</h3>',
            '</h4>',
            '</h5>',
            '</h6>',
            '</div>',
            '</legend>',
            '</fieldset>',
            '</dd>',
            '</dt>',
        ];

        // 1. remove complete head element
        $content = preg_replace('/<head>(.*?)<\/head>/i', '', $content);
        // 2. remove linebreaks, tabs
        $content = trim(str_replace(["\n", "\r", "\t"], '', $content));
        // 3. add linebreaks on some parts (</p> => </p><br />)
        $content = str_replace($tags2LineBreaks, '</p><br />', $content);
        // 4. insert space for table cells
        $content = str_replace(['</td>', '</th>'], '</td> ', $content);
        // 5. replace links <a href="xyz">LINK</a> -> LINK [xyz]
        $content = preg_replace('/<a[^>]+href\s*=\s*["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/misu', '$2 [$1]', $content);
        // 6. remove all tags (<b>bla</b><br /> => bla<br />)
        $content = strip_tags($content, '<br><address>');
        // 7. <br /> to \n
        $content = self::br2nl($content);
        // 8. replace &amp; in uris
        $content = preg_replace_callback('/http[^ ]+/', function ($match) {
            return str_replace('&amp;', '&', $match[0]);
        }, $content);

        return trim($content);
    }

    /**
     * Function br2nl is the opposite of nl2br.
     *
     * @param string $content
     * @return string
     */
    public static function br2nl(string $content): string
    {
        $array = [
            '<br >',
            '<br>',
            '<br/>',
            '<br />',
        ];

        return str_replace($array, PHP_EOL, $content);
    }

    /**
     * Function nl2br.
     *
     * @param string $content
     * @return string
     */
    public static function nl2br(string $content): string
    {
        return nl2br($content);
    }

    /**
     * Renders a string by passing it to a TYPO3 parseFunc.
     * You can either specify a path to the TypoScript setting or set the parseFunc options directly.
     * By default lib.parseFunc_RTE is used to parse the string.
     *
     * @param string $value string to render into html code
     * @param string $parseFuncTSPath
     * @throws \InvalidArgumentException
     * @return string rendered html code
     * @see HtmlViewHelper of TYPO3 core
     */
    public static function formatHtml(string $value, string $parseFuncTSPath = 'lib.parseFunc_RTE'): string
    {
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);

        return $contentObject->parseFunc($value, [], '< ' . $parseFuncTSPath);
    }
}
