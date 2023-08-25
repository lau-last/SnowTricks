<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    /**
     * @param UserInterface $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
        if (!$user->isIsRegistered()){
            throw new CustomUserMessageAuthenticationException("Votre compte n'est pas encore vérifié, regardez votre boîte mail !");
        }
    }


    /**
     * @param UserInterface $user
     * @return void
     */
    public function checkPostAuth(UserInterface $user): void
    {
        // TODO: Implement checkPostAuth() method.
    }


}