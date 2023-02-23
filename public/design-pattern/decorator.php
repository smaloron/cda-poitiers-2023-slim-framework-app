<?php

interface TileInterface
{
    public function getGold(): int;
    public function getFood(): int;
    public function getName(): string;
}

class Tile implements TileInterface
{

    private string $type;


    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getGold(): int
    {
        return 0;
    }

    public function getFood(): int
    {
        return 0;
    }

    public function getName(): string
    {
        return $this->type;
    }
}

class TileDecorator implements TileInterface
{
    public function __construct(protected TileInterface $tile)
    {
    }

    public function getGold(): int
    {
        return $this->tile->getGold();
    }

    public function getFood(): int
    {
        return $this->tile->getFood();
    }

    public function getName(): string
    {
        return $this->tile->getName();
    }
}

class WheatFieldDecorator extends TileDecorator
{
    public function getFood(): int
    {
        return 3 + $this->tile->getFood();
    }

    public function getName(): string
    {
        return $this->tile->getName() . " with wheat";
    }
}

class CowHerdDecorator extends TileDecorator
{
    public function getFood(): int
    {
        return 4 + $this->tile->getFood();
    }

    public function getName(): string
    {
        return $this->tile->getName() . " with cows";
    }
}



$plain = new CowHerdDecorator(
    new WheatFieldDecorator(
        new Tile("plain")
    )
);
echo "\n";
echo $plain->getName() . "\n";
echo "or = " . $plain->getGold();
echo "\n";
echo "nourriture = " . $plain->getFood();
echo "\n";

$mountain = new Tile("mountain");