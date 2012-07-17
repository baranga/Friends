<?php

class Friends_Relation_Method
    extends Friends_Relation_AbstractRelation
{
    private $_class;
    private $_method;

    public function __construct($class, $method)
    {
        $class = (string) $class;
        $method = (string) $method;
        if (!class_exists($class)) {
            throw new Friends_Relation_UnknownClassException($class);
        }
        if (!method_exists($class, $method)) {
            throw new Friends_Relation_UnknownMethodException($class, $method);
        }

        $friends   = array();
        $reflector = new ReflectionMethod($class, $method);
        $parser    = new Friends_Relation_DocCommentParser();

        do {
            $friends = array_merge(
                $friends,
                $parser->parse($reflector->getDocComment())
            );

            try {
                $reflector = $reflector->getPrototype();
            } catch (ReflectionException $noPrototypeException) {
                $reflector = null;
            }
        } while($reflector instanceof ReflectionMethod);

        parent::__construct($friends);
        $this->_class = $class;
        $this->_method = $method;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function getMethod()
    {
        return $this->_method;
    }
}
