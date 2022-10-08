<?php

 /** GENERATED CODE -- DO NOT MODIFY **/

namespace SSGraphQLSchema_21232f297a57a5a743894a0e4a801fc3;
use GraphQL\Type\Definition\CustomScalarType;
// @type:ObjectType
class ObjectType_b74c375731dc50c662d6ce08befe2db0 extends CustomScalarType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ObjectType',
            'serialize' => ['DNADesign\Elemental\GraphQL\Resolvers\Resolver', 'serialiseObjectType'],
            'parseValue' => ['DNADesign\Elemental\GraphQL\Resolvers\Resolver', 'parseValueObjectType'],
            'parseLiteral' => ['DNADesign\Elemental\GraphQL\Resolvers\Resolver', 'parseLiteralObjectType'],
        ]);
    }
}
