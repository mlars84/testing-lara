<?php

use App\Product;
use App\Order;

class OrderTest extends PHPUnit_Framework_TestCase
{
    // protected $order;
    // protected $product;
    // protected $product2;

    // public function setUp()
    // {
    //     $this->order = new Order;

    //     $this->product = new Product('Fallout 4', 59);
    //     $this->product2 = new Product('Pollowcase', 7);

    //     $this->order->add($this->product);
    //     $this->order->add($this->product2);
    // }

    /** @test */
    function an_order_consists_of_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertCount(2, $order->products());
    }

    /** @test */
    function an_order_can_determine_the_total_cost_of_all_its_products()
    {
        $order = $this->createOrderWithProducts();

        $this->assertEquals(66, $order->total());
    }

    //another way besides setUp()
    protected function createOrderWithProducts()
    {
        $order = new Order;

        $product = new Product('Fallout 4', 59);
        $product2 = new Product('Pollowcase', 7);

        $order->add($product);
        $order->add($product2);

        return $order;
    }
} 