<?php
/**
 *
 * @author mao.yongxiang
 * @since  2015-05-21
 */

/**
 * 获取HTML页面中的所有href属性的值
 * @param $href
 */
function getHref($url) {
    $html = file_get_contents($url);

    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);
    $hrefs = $xpath->evaluate('/html/body//a');

    for ($i = 0; $i < $hrefs->length; $i++) {
        $href = $hrefs->item($i);
        $url = $href->getAttribute('href');
        echo $url . '<br />';
    }
}

/**
 * 获取HTML页面中的所有链接
 * @param $url
 */
function getLink($url) {
    // 获取链接的HTML代码
    $html = file_get_contents($url);

    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);
    $hrefs = $xpath->evaluate('/html/body//a');

    for ($i = 0; $i < $hrefs->length; $i++) {
        $href = $hrefs->item($i);
        $url = $href->getAttribute('href');
        // 保留以http开头的链接
        if(substr($url, 0, 4) == 'http') {
            echo $url.'<br />';
        }
    }
}

$url = 'http://www.php100.com/';
getHref($url);
echo '<hr />';
getLink($url);