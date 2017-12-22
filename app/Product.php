<?php

namespace App;

class Product 
{
    protected $name;
    protected $cost;

    public function __construct($name, $cost)
    {
        $this->name = $name;  
        $this->cost = $cost; 
    }

    public function name()
    {
        return $this->name;
    }

    //assert that a product has a price associated with it $59
    public function cost()
    {
        return $this->cost;
    }
}