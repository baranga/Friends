<?php

class Friends_Relation_Class
    extends Friends_Relation_AbstractRelation
{
    private $_class;

    public function __construct($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        $class = (string) $class;
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf(
                'unknown class: "%s"', $class
            ));
        }

        $friends   = array();
        $reflector = new ReflectionClass($class);
        $parser    = new Friends_Relation_DocCommentParser();
        do {
            $friends = array_merge(
                $friends,
                $parser->parse($reflector->getDocComment())
            );

            $reflector = $reflector->getParentClass();
        } while ($reflector instanceof ReflectionClass);

        parent::__construct($friends);
        $this->_class = $class;
    }

    public function getClass()
    {
        return $this->_class;
    }
}
