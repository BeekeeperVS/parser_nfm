<?php
require_once __DIR__."/helper/url.php";

/**
 * @param $key
 * @param $default
 * @return mixed
 */
function env($key, $default = null)
{

    $value = getenv($key) ?: $_ENV[$key];

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

/**
 * @param $array1
 * @param $array2
 * @return mixed
 */
function arraysMap($array1, $array2)
{
    $result = $array1;
    foreach ($array2 as $item) {
        $result[] = $item;
    }
    return $result;
}

/**
 * @param string $cookieName
 * @param string $jsDocumentCookies
 * @return string
 */
function getCookie(string $cookieName, string $jsDocumentCookies): string
{
    $documentCookies = explode(';', $jsDocumentCookies);
    $arrayCookies = [];
    array_map(function ($item) use (&$arrayCookies) {
        $itemExplode = explode('=', trim($item));
        $arrayCookies[$itemExplode[0]] = $itemExplode[1];
    }, $documentCookies);
    if (isset($arrayCookies[$cookieName])) {
        return $arrayCookies[$cookieName];
    } else {
        return '';
    }
}

/**
 * @param $glue
 * @param $array
 * @param string $symbol
 * @return string
 */
function mapped_implode($glue, $array, $symbol = '=')
{
    return implode($glue, array_map(
            function ($k, $v) use ($symbol) {
                return $k . $symbol . $v;
            },
            array_keys($array),
            array_values($array)
        )
    );
}

/**
 * @param $glue
 * @param $array
 * @param string $symbol
 * @return string
 */
function ar_errors_implode($array, $glue = "; ", $symbol = '=')
{
    $result = "";
    foreach ($array as $field => $errors) {
        $result .= $field . $symbol;
        foreach ($errors as $item) {
            $result .= $item;
        }
        $result .= $glue;
    }

    return $result;
}

/**
 * @param string $baseLink
 * @param array $getData
 * @return string
 */
function buildGetUrl(string $baseLink, array $getData): string
{
    return $baseLink . "?" . http_build_query($getData);
}

/**
 * @param string $value
 * @return string
 */
function enSlug(string $value): string
{
    $value = trim(preg_replace('/[\W\s]+/u', ' ', $value));
    return substr(preg_replace("/\W/", '_', strtolower($value)), 0, 98);
}

/**
 * @param string $slug
 * @return string
 */
function deSlug(string $slug): string
{
    return str_replace("_", ' ', ucfirst($slug));
}

/**
 * Преопразование результату parse_url => url
 * @param array $parts
 * @return string
 */
function reverse_parse_url(array $parts)
{
    $url = '';
    if (!empty($parts['scheme'])) {
        $url .= $parts['scheme'] . ':';
    }
    if (!empty($parts['user']) || !empty($parts['host'])) {
        $url .= '//';
    }
    if (!empty($parts['user'])) {
        $url .= $parts['user'];
    }
    if (!empty($parts['pass'])) {
        $url .= ':' . $parts['pass'];
    }
    if (!empty($parts['user'])) {
        $url .= '@';
    }
    if (!empty($parts['host'])) {
        $url .= $parts['host'];
    }
    if (!empty($parts['port'])) {
        $url .= ':' . $parts['port'];
    }
    if (!empty($parts['path'])) {
        $url .= $parts['path'];
    }
    if (!empty($parts['query'])) {
        if (is_array($parts['query'])) {
            $url .= '?' . http_build_query($parts['query']);
        } else {
            $url .= '?' . $parts['query'];
        }
    }
    if (!empty($parts['fragment'])) {
        $url .= '#' . $parts['fragment'];
    }

    return $url;
}
