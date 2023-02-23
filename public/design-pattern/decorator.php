<?php

interface TileInterface
{
    public function getGold(): int;
    public function getFood(): int;
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
}

class WheatFieldDecorator extends TileDecorator
{
    public function getFood(): int
    {
        return 3 + $this->tile->getFood();
    }
}

class CowHerdDecorator extends TileDecorator
{
    public function getFood(): int
    {
        return 4 + $this->tile->getFood();
    }
}



$plain = new CowHerdDecorator(
    new WheatFieldDecorator(
        new Tile("plain")
    )
);
echo "\n";
echo "or = " . $plain->getGold();
echo "\n";
echo "nourriture = " . $plain->getFood();
echo "\n";

$mountain = new Tile("mountain");