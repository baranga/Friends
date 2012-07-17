<?php

class Friends_Relation_Function
    extends Friends_Relation_AbstractRelation
{
    private $_function;

    public function __construct($function)
    {
        $function = (string) $function;
        if (!function_exists($function)) {
            throw new Friends_Relation_UnknownFunctionException($function);
        }

        $reflector = new ReflectionFunction($function);
        $parser    = new Friends_Relation_DocCommentParser();
        $friends   = $parser->parse($reflector->getDocComment());

        parent::__construct($friends);
        $this->_function = $function;
    }

    public function getFunction()
    {
        return $this->_function;
    }
}
