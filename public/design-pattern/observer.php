<?php

interface SubscriberInterface
{
    public function update(string $message);

    //public function getName(): string;
}

abstract class AbstractPublisher
{
    protected array $subscriberList = [];

    public function addSubscriber(SubscriberInterface $sub)
    {
        $this->subscriberList[] = $sub;
    }

    abstract public function notify(string $message): void;
}

class Publisher extends AbstractPublisher
{
    public function notify(string $message): void
    {
        foreach ($this->subscriberList as $sub) {
            $sub->update($message);
        }
    }
}

class Logger implements SubscriberInterface
{
    public function update(string $message)
    {
        echo "\nJ'ai reçu notification de '$message' et je rentre cette info dans les logs\n";
    }
}

class Emailer implements SubscriberInterface
{
    public function update(string $message)
    {
        echo "\nje vais envoyer '$message' à tous les membres de la liste de diffusion \n";
    }
}

$publisher = new Publisher();
$publisher->addSubscriber(new Emailer);
$publisher->addSubscriber(new Logger);

$publisher->notify("Mode maintenance dans 5 minutes");