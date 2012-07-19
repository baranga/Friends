<?php

/** @brief base for classes with friends
 *
 */
abstract class Friends_Base_AutoDispatch
{
    /** @brief registry of dispatchers
     *  @var array<Friends_Dispatcher>
     */
    private static $_dispatchers = array();

    /** @brief magic get handler
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return self::_getDispatcher($this)
            ->dispatchGet($this, $property);
    }

    /** @brief magic set handler
     *
     * @param string $property
     * @param mixed $value
     * @return null
     */
    public function __set($property, $value)
    {
        self::_getDispatcher($this)
            ->dispatchSet($this, $property, $value);
    }

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
            $accessController = new Friends_AccessController($class);
            $dispatcher = new Friends_Dispatcher($accessController);
            self::$_dispatchers[$class] = $dispatcher;
        }
        return self::$_dispatchers[$class];
    }
}
