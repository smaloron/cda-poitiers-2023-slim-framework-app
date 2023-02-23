<?php

interface IcanSwim
{
    public function swim();
}

class LiveDuck implements IcanSwim
{
    public function swim()
    {
        echo "je nage dans la rivière";
    }
}

class PlasticDuck implements IcanSwim
{
    private bool $turnedOn = false;

    public function switchOn()
    {
        $this->turnedOn = true;
    }

    public function swim()
    {
        if ($this->turnedOn) {
            echo "Je nage dans la baignoire";
        }
    }
}

class SwimmingContest
{
    private array $contestants = [];

    public function addContestant(IcanSwim $contestant)
    {
        $this->contestants[] = $contestant;
    }

    public function startRace()
    {
        foreach ($this->contestants as $contestant) {
            $contestant->swim();
        }
    }
}
