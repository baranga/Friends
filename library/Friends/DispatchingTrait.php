<?php

trait Friends_DispatchingTrait
{
    /** @brief registry of dispatchers
     *  @var array<Friends_Dispatcher>
     */
    private static $_dispatchers = array();

    /** @brief magic call handler
     *
     *  @param string $method
     *  @param array $arguments
     *  @return mixed
     */
    public function __call($method, $arguments)
    {
        return
            self::_getDispatcher($this)
            ->dispatchCall($this, $method, $arguments);
    }

    /** @brief dispatcher for class/object
     *  @param mixed $objectOrClass
     *  @return Friends_Dispatcher
     */
    protected static function _getDispatcher($objectOrClass)
    {
        if (is_object($objectOrClass)) {
            $class = get_class($objectOrClass);
        } else {
            $class = (string) $objectOrClass;
        }
        if (!isset(self::$_dispatchers[$class])) {
            self::$_dispatchers[$class] = new Friends_Dispatcher(
                new Friends_AccessController($class)
            );
        }
        return self::$_dispatchers[$class];
    }
}
