<?php

interface IcanSpeak
{
    public function speak(): string;
}

class Dog implements IcanSpeak
{
    public function speak(): string
    {
        return "wouaf wouaf";
    }
}

class Duck implements IcanSpeak
{
    public function speak(): string
    {
        return "coin coin";
    }
}

class Bluetit implements IcanSpeak
{
    public function speak(): string
    {
        return "cui cui";
    }
}

class AnimalConference
{
    public function speak(IcanSpeak $animal)
    {
        echo $animal->speak();
    }
}