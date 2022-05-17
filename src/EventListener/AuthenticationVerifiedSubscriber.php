<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationVerifiedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            AuthenticationSuccessEvent::class => 'onAuthenticationSuccess'
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $user=$event->getAuthenticationToken()->getUser();
        if(!$user->isVerified()){
            throw new AuthenticationException("Vérifier vos mails et valider votre adresse.");
        }
    }
}