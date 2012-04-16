<?php

class Friends_Relation_Property
    extends Friends_Relation_AbstractRelation
{
    private $_property;

    public function __construct($class, $property)
    {
        $class = (string) $class;
        $property = (string) $property;
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf(
                'unknown class: "%s"', $class
            ));
        }
        if (!property_exists($class, $property)) {
            throw new InvalidArgumentException(sprintf(
                'unknown property: "%s"', $property
            ));
        }

        $reflector = new ReflectionProperty($class, $property);
        $parser    = new Friends_Relation_DocCommentParser();
        $friends   = $parser->parse($reflector->getDocComment());

        parent::__construct($friends);
        $this->_property = $property;
    }

    public function getProperty()
    {
        return $this->_property;
    }
}
