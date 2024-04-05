<?php

namespace App\Services;

class HtmlImageFullPath
{
    public function replaceImageSrc($html)
    {
        $baseUrl = env('APP_URL');
        $pattern = '/<img.*?src="(.*?)\/storage"/i';
        $replacement = '<img src="' . $baseUrl. '\1"';
        return preg_replace($pattern, $replacement, $html);
    }

}
