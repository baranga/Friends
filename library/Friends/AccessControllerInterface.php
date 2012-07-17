<?php

interface Friends_AccessControllerInterface
{
    /** class access controller is for
     *  @return string
     */
    public function getClass();

    /** get of property allowed for getter
     *  @param string $property name of property
     *  @param Friends_FriendInterface $getter getting object
     *  @return boolean
     */
    public function isGetAllowed($property, Friends_FriendInterface $getter);

    /** assert that get of property is allowed for getter
     *  @param string $property name of property
     *  @param Friends_FriendInterface $setter getting object
     *  @throws Friends_AccessController_GetPropertyNotAllowedException if get is not
     *  allowed
     */
    public function assertGetIsAllowed($property, Friends_FriendInterface $getter);

    /** set of property allowed for getter
     *  @param string $property name of property
     *  @param Friends_FriendInterface $getter setting object
     *  @return boolean
     */
    public function isSetAllowed($property, Friends_FriendInterface $setter);

    /** assert that set of property is allowed for setter
     *  @param string $property name of property
     *  @param Friends_FriendInterface $setter setting object
     *  @throws Friends_AccessController_SetPropertyNotAllowedException if set is not
     *  allowed
     */
    public function assertSetIsAllowed($property, Friends_FriendInterface $getter);

    /** call of method allowed for caller
     *  @param string $method name of method
     *  @param Friends_FriendInterface $caller calling object
     *  @return boolean
     */
    public function isCallAllowed($method, Friends_FriendInterface $caller);

    /** assert that call of method is allowed for caller
     *  @param string $method name of method
     *  @param Friends_FriendInterface $caller calling object
     *  @throws Friends_AccessController_SetPropertyNotAllowedException if call is not
     *  allowed
     */
    public function assertCallIsAllowed($property, Friends_FriendInterface $getter);
}
