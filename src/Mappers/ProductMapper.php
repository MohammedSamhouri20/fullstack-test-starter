<?php

namespace App\Mappers;

class ProductMapper extends BaseMapper
{
    public static function map($data): array
    {
        return array_map(function ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'inStock' => $product->isInStock(),
                'gallery' => $product->getGallery(),
                'description' => $product->getDescription(),
                'category' => $product->getCategory()->getName(),
                'attributes' => AttributeSetMapper::map($product->getAttributeItems()->toArray()),
                'prices' => PriceMapper::map($product->getPrices()->toArray()),
                'brand' => $product->getBrand(),
            ];
        }, $data);
    }

    public static function mapSingle($product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'inStock' => $product->isInStock(),
            'gallery' => $product->getGallery(),
            'description' => $product->getDescription(),
            'category' => $product->getCategory()->getName(),
            'attributes' => AttributeSetMapper::map($product->getAttributeItems()->toArray()),
            'prices' => PriceMapper::map($product->getPrices()->toArray()),
            'brand' => $product->getBrand(),
        ];
    }
}
