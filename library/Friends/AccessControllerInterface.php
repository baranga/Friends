<?php

interface Friends_AccessControllerInterface
{
    /** class access controller is for
     *  @return string
     */
    public function getClass();

    /** get of property allowed for getter
     *  @param string $property name of property
     *  @param Friends_Friend $getter getting object
     *  @return boolean
     */
    public function isGetAllowed($property, Friends_Friend $getter);

    /** assert that get of property is allowed for getter
     *  @param string $property name of property
     *  @param Friends_Friend $setter getting object
     *  @throws Friends_AccessController_GetPropertyNotAllowedException if get is not
     *  allowed
     */
    public function assertGetIsAllowed($property, Friends_Friend $getter);

    /** set of property allowed for getter
     *  @param string $property name of property
     *  @param Friends_Friend $getter setting object
     *  @return boolean
     */
    public function isSetAllowed($property, Friends_Friend $setter);

    /** assert that set of property is allowed for setter
     *  @param string $property name of property
     *  @param Friends_Friend $setter setting object
     *  @throws Friends_AccessController_SetPropertyNotAllowedException if set is not
     *  allowed
     */
    public function assertSetIsAllowed($property, Friends_Friend $getter);

    /** call of method allowed for caller
     *  @param string $method name of method
     *  @param Friends_Friend $caller calling object
     *  @return boolean
     */
    public function isCallAllowed($method, Friends_Friend $caller);

    /** assert that call of method is allowed for caller
     *  @param string $method name of method
     *  @param Friends_Friend $caller calling object
     *  @throws Friends_AccessController_SetPropertyNotAllowedException if call is not
     *  allowed
     */
    public function assertCallIsAllowed($property, Friends_Friend $getter);
}
