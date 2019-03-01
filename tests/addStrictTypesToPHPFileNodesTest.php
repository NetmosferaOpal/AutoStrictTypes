<?php declare(strict_types = 1);

namespace Netmosfera\OpalAutoStrictTypesTests;

use PhpParser\ParserFactory as PF;
use PhpParser\PrettyPrinter\Standard;
use PHPUnit\Framework\TestCase;
use TypeError;
use function Netmosfera\OpalAutoStrictTypes\addStrictTypesToPHPFileNodes;

class addStrictTypesToPHPFileNodesTest extends TestCase
{
    public function parse(String $PHP){
        return (new PF())->create(PF::ONLY_PHP7)->parse("<?php " . $PHP);
    }

    public function stringify(Array $nodes): String{
        return (new Standard())->prettyPrint($nodes);
    }

    public function data_adds_strict_types(){
        yield [""];
        yield ["declare(yolo = 42);"];
        yield ["declare(yolo = 42, swag = 123);"];
        yield ["declare(yolo = 42, swag = 123, rad = 456);"];
    }

    /** @dataProvider data_adds_strict_types */
    public function test_adds_strict_types(String $unrelatedDeclare){
        $weakSource = $unrelatedDeclare . '(function(int $i){})("123");';
        $originalNodes = $this->parse($weakSource);
        $modifiedNodes = addStrictTypesToPHPFileNodes($originalNodes);
        $strictSource = $this->stringify($modifiedNodes);
        $this->expectException(TypeError::CLASS);
        @eval($strictSource);
    }

    public function data_leaves_weak_types(){
        yield ["declare(strict_types = 0);"];
        yield ["declare(yolo = 42, strict_types = 0);"];
        yield ["declare(yolo = 42, swag = 123, strict_types = 0);"];
    }

    /** @doesNotPerformAssertions @dataProvider data_leaves_weak_types */
    public function test_leaves_weak_types(String $weakTypesDeclaration){
        $weakSource = $weakTypesDeclaration . '(function(int $i){})("123");';
        @eval($weakSource);
        $originalNodes = $this->parse($weakSource);
        $modifiedNodes = addStrictTypesToPHPFileNodes($originalNodes);
        $strictSource = $this->stringify($modifiedNodes);
        @eval($strictSource);
    }
}
