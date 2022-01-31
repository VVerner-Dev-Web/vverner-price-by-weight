<?php

namespace PBW;

defined('ABSPATH') || exit('No direct script access allowed');

class Product
{
    private const PREFIX = '_pbw_';

    public $ID;
    private $_product;

    public function __construct(int $wooCommerceProductID)
    {
        $this->ID = $wooCommerceProductID;
        $this->_product = wc_get_product( $this->ID );
    }
    
    public function get(string $prop)
    {
        return $this->_product->get_meta(self::PREFIX . $prop);
    }

    public function set(string $prop, $value): void
    {
        $this->_product->add_meta_data(self::PREFIX . $prop, $value, true);
    }

    public function isActive(): bool
    {
        return intval($this->get('active')) === 1;
    }

    public function getWeight(): float
    {
        $weight = (int) $this->get('weight');
        return $weight === 0 ? (int) $this->getInheritance('default_weight') : $weight;
    }

    public function isKgPriceVisible(): bool
    {
        return 
            $this->get('show_kg_price') === 'yes' || 
            $this->get('show_kg_price') === 'inherit' && $this->getInheritance('show_kg_price') === 'yes'
            ;
    }

    public function getSalesType(): string
    {
        return $this->get('sales_type') === 'inherit' ?
            $this->getInheritance('sales_type'):
            $this->get('sales_type')
        ;      
    }

    public function getWeightStep(): string
    {
        return intval($this->get('step_weight')) === 0 ?
            $this->getInheritance('default_step_weight'):
            $this->get('step_weight')
        ;      
    }

    public function getPrice(): float
    {
        return (float) $this->_product->get_price();
    }

    private function getInheritance(string $prop)
    {
        return pbw_getApp()->get($prop);
    }

    public function save(): void
    {
        $this->_product->save();
    }

    public function getJsonSettings(): string
    {
        return wp_json_encode([
            'weight'    => (float) $this->getWeight(),
            'step'      => (int) $this->getWeightStep(),
            'price'     => (float) $this->getPrice()
        ]);
    }
}
