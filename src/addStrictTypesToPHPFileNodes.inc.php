<?php declare(strict_types = 1);

namespace Netmosfera\OpalAutoStrictTypes;

use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\DeclareDeclare;
use function array_unshift;

function addStrictTypesToPHPFileNodes(Array $nodes): array{
    $firstNode = $nodes[0] ?? NULL;

    if($firstNode instanceof Declare_){
        foreach($firstNode->declares as $declareDeclare){
            if($declareDeclare->key->name === "strict_types"){
                return $nodes;
            }
        }
    }

    $identifier = new Identifier("strict_types");
    $declareDeclare = new DeclareDeclare($identifier, new LNumber(1));
    $declare = new Declare_([$declareDeclare], NULL, []);
    array_unshift($nodes, $declare);

    return $nodes;
}
