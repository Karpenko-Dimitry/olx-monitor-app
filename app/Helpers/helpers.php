<?php

if (!function_exists('addQueryToUrl')) {
    /**
     * @param string $url
     * @param array $query
     * @return string
     */
    function addQueryToUrl(string $url, array $query)
    {
        $parsedUrl = parse_url($url);
        if ($parsedUrl['path'] == null) {
            $url .= '/';
        }

        $separatorFirst = (!isset($parsedUrl['query']) || $parsedUrl['query'] == null) ? '?' : '&';
        $separatorOther = '&';

        $first = true;
        foreach ($query as $key => $item) {
            $url .= ($first ? $separatorFirst : $separatorOther) . $key . '=' . $item;
            $first = false;
        }

        return $url;
    }
}
