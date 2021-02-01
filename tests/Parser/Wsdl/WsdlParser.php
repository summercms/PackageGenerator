<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageGenerator\Tests\Parser\Wsdl;

use WsdlToPhp\PackageGenerator\Generator\Generator;
use WsdlToPhp\PackageGenerator\Parser\Wsdl\TagImport;
use WsdlToPhp\PackageGenerator\Parser\Wsdl\TagInclude;
use WsdlToPhp\PackageGenerator\Tests\AbstractTestCase;
use WsdlToPhp\PackageGenerator\Parser\SoapClient\Structs;
use WsdlToPhp\PackageGenerator\Parser\SoapClient\Functions;

abstract class WsdlParser extends AbstractTestCase
{
    public static function generatorInstance(string $wsdlPath, bool $reset = true, bool $parseSoapStructs = true, bool $parseSoapFunctions = true): Generator
    {
        $generator = self::getInstance($wsdlPath, $reset);
        $parsers = [
            new TagImport($generator),
            new TagInclude($generator),
        ];

        if ($parseSoapStructs === true) {
            $parsers[] = new Structs($generator);
        }

        if ($parseSoapFunctions === true) {
            $parsers[] = new Functions($generator);
        }

        foreach ($parsers as $parser) {
            $parser->parse();
        }

        return $generator;
    }
}
