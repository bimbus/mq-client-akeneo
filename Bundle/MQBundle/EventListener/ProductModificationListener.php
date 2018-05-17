<?php

namespace Bimbus\Bundle\MQBundle\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Pim\Component\Catalog\Model\ProductInterface;
use Google\Cloud\PubSub\PubSubClient;

class ProductModificationListener
{
    private $mqclient;

    private $topic;

    public function __construct(PubSubClient $mqclient, $topic)
    {
        $this->mqclient = $mqclient;
        $this->topic = $topic;
    }

    public function onPostSave(GenericEvent $event)
    {
        $subject = $event->getSubject();

        if (! $subject instanceof ProductInterface) {
            return;
        }

        $topic = $this->mqclient->topic($this->topic);

        $topic->publish([
            'data' => "Updated product",
            'attributes' => [
                'sku' => $subject->getIdentifier(),
                'updated' => $subject->getUpdated(),
                'enabled' => $subject->isEnabled(),
            ]
        ]);
    }
}
