<?php

class Friends_AccessController
    implements Friends_AccessControllerInterface
{
    /** class
     *  @var string
     */
    private $_class;

    /** private lock state
     *  @var boolean
     */
    private $_lockPrivate = true;

    /** reflector of class
     *  @var ReflectionClass
     */
    private $_classReflector = null;

    /** relation of class
     *  @var Friends_Relation_Class
     */
    private $_classRelation = null;

    /** list of loaded property relations
     *  @var array<Friends_Relation_Property>
     */
    private $_propertyRelations = array();

    /** list of loaded method relations
     *  @var array<Friends_Relation_Method>
     */
    private $_methodRelations = array();

    public function __construct($class, $lockPrivate = true)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $class = (string) $class;
        if (!class_exists($class)) {
            throw new Friends_AccessController_UnknownClassException($class);
        }

        $this->_class       = $class;
        $this->_lockPrivate = (bool) $lockPrivate;
    }

    /** class
     *  @return string
     */
    public function getClass()
    {
        return $this->_class;
    }

    /** has class
     *  @param string $class
     *  @return boolean
     */
    public function hasClass($class)
    {
        return $this->_class === (string) $class;
    }

    /** get of property allowed for getter
     *  @param string $property name of property
     *  @param Friends_Friend $getter getting object
     *  @return boolean
     */
    public function isGetAllowed($property, Friends_Friend $getter)
    {
        $property = (string) $property;
        $this->_assertPropertyExists($property);

        // check for private
        if ($this->_lockPrivate) {
            $propertyReflector = $this->_getPropertyReflector($property);
            if ($propertyReflector->isPrivate()) {
                return false;
            }
        }

        return $this->_isPropertyFriend($property, $caller);
    }

    /** assert that get of property is allowed for getter (fluid)
     *  @param string $property name of property
     *  @param Friends_Friend $setter getting object
     *  @return Friends_AccessController
     *  @throws Friends_AccessController_GetPropertyNotAllowedException if get is not
     *  allowed
     */
    public function assertGetIsAllowed($property, Friends_Friend $getter)
    {
        if (!$this->isGetAllowed($property, $caller)) {
            throw new Friends_AccessController_SetPropertyNotAllowedException(
                $this->_class, $property
            );
        }
        return $this;
    }

    /** set of property allowed for getter
     *  @param string $property name of property
     *  @param Friends_Friend $getter setting object
     *  @return boolean
     */
    public function isSetAllowed($property, Friends_Friend $setter)
    {
        return $this->isGetAllowed($property, $setter);
    }

    /** assert that set of property is allowed for setter (fluid)
     *  @param string $property name of property
     *  @param Friends_Friend $setter setting object
     *  @return Friends_AccessController
     *  @throws Friends_AccessController_SetPropertyNotAllowedException if set is not
     *  allowed
     */
    public function assertSetIsAllowed($property, Friends_Friend $getter)
    {
        if (!$this->isSetAllowed($property, $caller)) {
            throw new Friends_AccessController_SetPropertyNotAllowedException(
                $this->_class, $property
            );
        }
        return $this;
    }

    /** call of method allowed for caller
     *  @param string $method name of method
     *  @param Friends_Friend $caller calling object
     *  @return boolean
     */
    public function isCallAllowed($method, Friends_Friend $caller)
    {
        $method = (string) $method;
        $this->_assertMethodExists($method);

        // check for private
        if ($this->_lockPrivate) {
            $methodReflector = $this->_getMethodReflector($method);
            if ($methodReflector->isPrivate()) {
                return false;
            }
        }

        return $this->_isMethodFriend($method, $caller);
    }

    /** assert that call of method is allowed for caller (fluid)
     *  @param string $method name of method
     *  @param Friends_Friend $caller calling object
     *  @return Friends_AccessController
     *  @throws Friends_AccessController_SetPropertyNotAllowedException if call is not
     *  allowed
     */
    public function assertCallIsAllowed($method, Friends_Friend $caller)
    {
        if (!$this->isCallAllowed($method, $caller)) {
            throw new Friends_AccessController_CallMethodNotAllowedException(
                $this->_class, $method
            );
        }
        return $this;
    }

    /** assert class has property
     *  @throws Friends_AccessController_InvalidPropertyException if class has not
     *  property
     */
    private function _assertPropertyExists($property)
    {
        if (!$this->_getClassReflector()->hasProperty($property)) {
            throw new Friends_AccessController_InvalidPropertyException($property);
        }
    }

    /** assert class has method
     *  @throws Friends_AccessController_InvalidMethodException if class has not
     *  method
     */
    private function _assertMethodExists($method)
    {
        if (!$this->_getClassReflector()->hasMethod($method)) {
            throw new Friends_AccessController_InvalidMethodException($method);
        }
    }

    /** reflector for class
     *  @return ReflectionClass
     */
    private function _getClassReflector()
    {
        if ($this->_classReflector === null) {
            $this->_classReflector = new ReflectionClass($this->_class);
        }
        return $this->_classReflector;
    }

    /** reflector for property of class
     *  @return ReflectionProperty
     */
    private function _getPropertyReflector($property)
    {
        return $this->_getClassReflector()->getProperty($property);
    }

    /** reflector for method of class
     *  @return ReflectionMethod
     */
    private function _getMethodReflector($method)
    {
        return $this->_getClassReflector()->getMethod($method);
    }

    /** @brief class relationship
     *  @return Friends_Relation_Class
     */
    private function _getClassRelation()
    {
        if ($this->_classRelation === null) {
            $this->_classRelation = new Friends_Relation_Class($this->_class);
        }
        return $this->_classRelation;
    }

    /** @brief property relationship
     *  @param string $property property name
     *  @return Friends_Relation_Property
     */
    private function _getPropertyRelation($property)
    {
        if (!isset($this->_propertyRelations[$property])) {
            $this->_propertyRelations[$property] = new Friends_Relation_Property(
                $this->_class, $property
            );
        }
        return $this->_propertyRelations[$property];
    }

    /** @brief method relationship
     *  @param string $method method name
     *  @return Friends_Relation_Method
     */
    private function _getMethodRelation($method)
    {
        if (!isset($this->_methodRelations[$method])) {
            $this->_methodRelations[$method] = new Friends_Relation_Method(
                $this->_class, $method
            );
        }
        return $this->_methodRelations[$method];
    }

    /** @brief check if caller is a friend of property
     *  @param string $property
     *  @param Friends_Friend $caller
     *  @return boolean
     */
    private function _isPropertyFriend($property, Friends_Friend $caller)
    {
        return
            $this->_getClassRelation()->isFriend($caller) ||
            $this->_getPropertyRelation($property)->isFriend($caller);
    }

    /** @brief check if caller is a friend of method
     *  @param string $method
     *  @param Friends_Friend $caller
     *  @return boolean
     */
    private function _isMethodFriend($method, Friends_Friend $caller)
    {
        return
            $this->_getClassRelation()->isFriend($caller) ||
            $this->_getMethodRelation($method)->isFriend($caller);
    }
}
