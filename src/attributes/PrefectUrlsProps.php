<?php
namespace nystudio107\craftTwigBaseTemplates\attributes;

use Attribute;

#[Attribute]
class PrefectUrlsProps
{
    /* @var string[] $prefetchUrls The URLs to prefetch */
    public array $prefetchUrls = [];

    /* @var bool $outputLinks Whether <link> tags should be output */
    public bool $outputLinks = true;

    /* @var bool $outputHeaders Whether Link: headers should be output */
    public bool $outputHeaders = true;
}
