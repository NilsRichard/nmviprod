<?php

namespace App\Form\FormExtension;

use App\EventSubscriber\HoneyPotSubscriber;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class HoneyPotType extends AbstractType
{
    private LoggerInterface $logger;
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack, LoggerInterface $logger)
    {
        $this->requestStack = $requestStack;
        $this->logger = $logger;
    }

    public const BOT_TRAP = "interest";
    public const BOT_CANDY = "faxNumber";

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::BOT_TRAP, TextType::class, $this->setHoneyPotFieldConfig())
            ->add(self::BOT_CANDY, TextType::class, $this->setHoneyPotFieldConfig())
            ->addEventSubscriber(new HoneyPotSubscriber($this->requestStack, $this->logger));
    }

    protected function setHoneyPotFieldConfig(): array
    {
        return [
            'attr' => [
                'autocomplete' => 'off', 'tabindex' => '-1'
            ],
            // 'data' => 'fake data :(', // only for test
            'mapped' => false,
            'required' => false
        ];
    }
}
