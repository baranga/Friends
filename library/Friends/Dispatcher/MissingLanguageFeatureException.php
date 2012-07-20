<?php

class Friends_Dispatcher_MissingLanguageFeatureException
    extends RuntimeException
    implements Friends_Dispatcher_ExceptionInterface
{
    const CODE_MISSING_SET_PROPERTY_ACCESSIBLE = 1;
    const CODE_MISSING_SET_METHOD_ACCESSIBLE = 2;

    static public function missingSetPropertyAccessible()
    {
        return new Friends_Dispatcher_MissingLanguageFeatureException(
            'missing ReflectionProperty::setAccessible',
            self::CODE_MISSING_SET_PROPERTY_ACCESSIBLE
        );
    }

    static public function missingSetMethodAccessible()
    {
        return new Friends_Dispatcher_MissingLanguageFeatureException(
            'missing ReflectionMethod::setAccessible',
            self::CODE_MISSING_SET_METHOD_ACCESSIBLE
        );
    }
}