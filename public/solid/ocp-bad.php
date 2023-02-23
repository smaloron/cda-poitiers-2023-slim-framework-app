<?php

class Dog
{
    public function bark()
    {
        return "wouaf wouaf";
    }
}

class Duck
{
    public function quack()
    {
        return "coin coin";
    }
}

class AnimalConference
{
    public function speak($animal)
    {
        if ($animal instanceof Dog) {
            echo $animal->bark();
        } else if ($animal instanceof Duck) {
            echo $animal->quack();
        }
    }
}