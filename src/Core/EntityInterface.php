<?php

namespace Seb\App\Core;

interface EntityInterface
{

    public function getId(): ?int;

    public function setId(int $id): self;
}