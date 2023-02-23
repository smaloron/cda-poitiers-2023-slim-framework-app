<?php

interface SubscriberInterface
{
    public function update(string $eventName, string $message);

    //public function getName(): string;
}

abstract class AbstractPublisher
{
    protected array $subscriberList = [];

    public function addSubscriber(string $eventName, SubscriberInterface $sub)
    {
        $this->subscriberList[$eventName][] = $sub;
    }

    abstract public function notify(string $eventName, string $message): void;
}

class Publisher extends AbstractPublisher
{
    public function notify(string $eventName, string $message): void
    {
        foreach ($this->subscriberList[$eventName] as $sub) {
            $sub->update($eventName, $message);
        }
    }
}

class Logger implements SubscriberInterface
{
    public function update(string $eventName, string $message)
    {
        echo "\n$eventName: J'ai reçu notification de '$message' et je rentre cette info dans les logs\n";
    }
}

class Emailer implements SubscriberInterface
{
    public function update(string $eventName, string $message)
    {
        echo "\n$eventName: je vais envoyer '$message' à tous les membres de la liste de diffusion \n";
    }
}

$publisher = new Publisher();
$publisher->addSubscriber("mode.maintenance", new Emailer);
$publisher->addSubscriber("mode.maintenance", new Logger);
$publisher->addSubscriber("system.error", new Logger);

$publisher->notify("mode.maintenance", "Mode maintenance dans 5 minutes");
$publisher->notify("system.error", "On a encore oublié un point virgule");