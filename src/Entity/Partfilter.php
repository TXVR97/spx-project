<?php

namespace App\Entity;

class Partfilter{
    private $partname;

    public function getPartName(){
        return $this->partname;
}
public function setPartName(string $name): self
    {
        $this->partname = $name;

        return $this;
    }
}