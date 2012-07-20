<?php

class Friends_Dispatcher_InvalidObjectException
    extends InvalidArgumentException
    implements Friends_Dispatcher_ExceptionInterface
{
    public function __construct($object, $class)
    {
        $message = sprintf(
            'object must be a instance of "%s", got instead ',
            $class
        );
        if (is_object($object)) {
            $message .= sprintf(
                'a instance of "%s"',
                get_class($object)
            );
        } else {
            $message .= sprintf(
                'a value of type "%s"',
                gettype($object)
            );
        }
        parent::__construct($message);
    }
}
