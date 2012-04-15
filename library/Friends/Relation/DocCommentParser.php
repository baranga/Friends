<?php

class Friends_Relation_DocCommentParser
{
    public function parse($comment)
    {
        $comment = (string) $comment;
        $annotations = $this->_getAnnotations($comment);
        $friends     = $this->_extractFriendsFromAnnotations($annotations);
        return $friends;
    }

    private function _getAnnotations($comment)
    {
        $annotations = array();
        preg_match_all(
            '/@friends?\s+[\w:\\\\,\s*]+/',
            $comment,
            $matches
        );

        return $matches[0];
    }

    private function _extractFriendsFromAnnotations(array $annotations)
    {
        $friends = array();
        foreach ($annotations as $annotation) {
            $annotation = preg_replace('/^@friends?\s+/', '', $annotation);
            $annotation = preg_replace('/[^\w:\\\\,\s]/', '', $annotation);
            $annotation = preg_replace('/\n\s*\n.*/', '', $annotation);
            $annotation = preg_replace('/(\s|,)+/', ' ', $annotation);
            $annotation = trim($annotation);
            $rawFriends = explode(' ', $annotation);
            foreach ($rawFriends as $rawFriend) {
                $friends[] = $this->_buildFriend($rawFriend);
            }
        }
        return $friends;
    }

    private function _buildFriend($rawFriend)
    {
        $match = preg_match('/^(\\\\?[A-Z][\w\\\\]*)(::(\w+))?/', $rawFriend, $matches);
        if ($match && isset($matches[2])) {
            return new Friends_Friend_Method($matches[1], $matches[3]);
        } elseif ($match) {
            return new Friends_Friend_Class($rawFriend);
        } else {
            return new Friends_Friend_Function($rawFriend);
        }
    }
}
