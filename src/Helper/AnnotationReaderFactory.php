<?php

namespace Mapper\Helper;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\DocParser;

class AnnotationReaderFactory
{
    public static function create(bool $ignoreNotImportedAnnotations = false)
    {
        $parser = new DocParser();
        $parser
            ->setIgnoreNotImportedAnnotations($ignoreNotImportedAnnotations);

        return new AnnotationReader($parser);
    }
}
