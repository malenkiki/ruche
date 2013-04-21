<?php

namespace Malenki\Ruche\Util;

use dflydev\markdown\MarkdownExtraParser;


class RichText
{
    protected $str = null;

    public function __construct($str)
    {
        if(is_string($str) || is_null($str))
        {
            $this->str = $str;
        }
    }

    public static function format($str)
    {
        $rt = new self($str);
        return $rt->getFormated();
    }

    public function getRaw()
    {
        return $this->str;
    }

    public function getFormated($str)
    {
        $parser = new MarkdownExtraParser();
        return $parser->transformMarkdown($str);
    }

    public function __toString()
    {
        return $this->getFormated();
    }
}
