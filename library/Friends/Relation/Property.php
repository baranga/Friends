<?php

class Friends_Relation_Property
    extends Friends_Relation_AbstractRelation
{
    private $_class;
    private $_property;

    public function __construct($class, $property)
    {
        $class = (string) $class;
        $property = (string) $property;
        if (!class_exists($class)) {
            throw new Friends_Relation_UnknownClassException($class);
        }
        if (!property_exists($class, $property)) {
            throw new Friends_Relation_UnknownPropertyException($class, $property);
        }

        $reflector = new ReflectionProperty($class, $property);
        $parser    = new Friends_Relation_DocCommentParser();
        $friends   = $parser->parse($reflector->getDocComment());

        parent::__construct($friends);
        $this->_class = $class;
        $this->_property = $property;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function getProperty()
    {
        return $this->_property;
    }
}
