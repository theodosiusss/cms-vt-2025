<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {}
    public function onLogoutEvent(LogoutEvent $event): void
    {
        $request = $event->getRequest();
        $locale = $request->getLocale();

        $url = $this->urlGenerator->generate('app_login', [
            '_locale' => $locale,
        ]);

        $event->setResponse(new RedirectResponse($url));    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
