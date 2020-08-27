<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class CollectionVoter extends AbstractVoter
{
    public const CREATE = 'collection_create';
    public const EDIT = 'collection_edit';
    public const DELETE = 'collection_delete';

    protected function supports(string $attribute, $subject)
    {
        return in_array($attribute, [
            self::CREATE,
            self::EDIT,
            self::DELETE
        ], true);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $this->getUser($token);

        if (null === $user) {
            return false;
        }

        switch ($attribute) {
            case self::CREATE:
                if (in_array(User::ROLE_USER, $user->getRoles(), true)) {
                    return false;
                }

                return true;
            case self::EDIT:
                if ($user->getCollectionsUsers()->contains($subject)) {
                    return true;
                }
                break;
            case self::DELETE:
                if ($user->getCollectionsUsers()->contains($subject)) {
                    return true;
                }
        }

        return false;
    }
}
