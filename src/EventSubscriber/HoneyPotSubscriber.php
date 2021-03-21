<?php

namespace App\EventSubscriber;

use App\Form\FormExtension\HoneyPotType;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HoneyPotSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack, LoggerInterface $logger)
    {
        $this->requestStack = $requestStack;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'checkHoneyJar'
        ];
    }

    public function checkHoneyJar(FormEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return;
        }

        $data = $event->getData();

        if (!array_key_exists(HoneyPotType::BOT_TRAP, $data) || !array_key_exists(HoneyPotType::BOT_CANDY, $data)) {
            throw new HttpException(400, "Don't touch my form.");
        }

        [
            HoneyPotType::BOT_TRAP => $botTrap,
            HoneyPotType::BOT_CANDY => $botCandy
        ] = $data;

        if ($botTrap !== "" || $botCandy !== "") {
            $this->logger->info("Possible bot request with IP: '{$request->getClientIp()}' occured. "
                . "Trap field contained: '{$botTrap}' and candy contained: '{$botCandy}'.");
            throw new HttpException(403, "Keep out, bot!");
        }
    }
}
