<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractVoter extends Voter
{
    protected function getUser(TokenInterface $token): ?User
    {
        $user = $token->getUser();

        if ($user instanceof User) {
            return $user;
        }

        return null;
    }
}
