<?php

abstract class Friends_Dispatcher_AbstractNotAllowedException
    extends RuntimeException
{
    const CODE_PRIVATE_IS_LOCKED = 1;
    const CODE_NOT_A_FRIEND = 2;

    protected $_reasons = array(
        self::CODE_PRIVATE_IS_LOCKED => 'private is locked',
        self::CODE_NOT_A_FRIEND => 'not a friend',
    );

    protected function _appendReasonIfPossible($message, $code)
    {
        $reason = $this->_getReason($code);
        if ($reason) {
            $message .= sprintf(' (reason: %s)', $reason);
        }
        return $message;
    }

    protected function _getReason($code)
    {
        if (!isset($this->_reasons[$code])) {
            return null;
        }
        return $this->_reasons[$code];
    }
}
