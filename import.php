<?php

use App\Models\Category;
use App\Models\ClothingProduct;
use App\Models\TechProduct;
use App\Models\TextAttribute;
use App\Models\SwatchAttribute;
use App\Models\AbstractAttribute;
use App\Models\AttributeItem;
use App\Models\Currency;
use App\Models\Price;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Load EntityManager from bootstrap.php
$entityManager = require 'bootstrap.php';

// Load the JSON file
$jsonFile = __DIR__ . '/data/data.json';
$jsonData = json_decode(file_get_contents($jsonFile), true)['data'];

if (!$jsonData) {
    die("Failed to load JSON file. Check file path.");
}

// Step 1: Insert Categories
$categories = [];
foreach ($jsonData['categories'] as $catData) {
    $category = new Category($catData['name']);
    $entityManager->persist($category);
    $categories[$catData['name']] = $category;
}
$entityManager->flush();
echo "✅ Categories imported successfully.\n";

// Step 2: Insert Products Using Polymorphism
$productClasses = [
    'tech' => TechProduct::class,
    'clothes' => ClothingProduct::class
];

$products = [];
foreach ($jsonData['products'] as $prodData) {
    $category = $categories[$prodData['category']] ?? null;
    $productClass = $productClasses[$prodData['category']] ?? ClothingProduct::class;

    $product = new $productClass(
        $prodData['id'],
        $prodData['name'],
        $prodData['inStock'],
        $prodData['description'],
        $category,
        $prodData['gallery'],
        $prodData['brand'],
    );

    $entityManager->persist($product);
    $products[$prodData['id']] = $product;
}
$entityManager->flush();
echo "✅ Products imported successfully.\n";

// Step 3: Insert Attributes (General List of Attributes Like "Color", "Size")
$attributeClasses = [
    'swatch' => SwatchAttribute::class,
    'text' => TextAttribute::class
];

$attributes = []; // Store unique attributes
foreach ($jsonData['products'] as $prodData) {
    foreach ($prodData['attributes'] as $attrData) {
        $attributeName = $attrData['name'];

        // Check if attribute already exists (shared across products)
        if (!isset($attributes[$attributeName])) {
            $attributeClass = $attributeClasses[$attrData['type']] ?? TextAttribute::class;
            $attribute = new $attributeClass(uniqid(), $attributeName);
            $entityManager->persist($attribute);
            $attributes[$attributeName] = $attribute;
        }
    }
}
$entityManager->flush();
echo "✅ Attributes imported successfully.\n";

// Step 4: Insert Attribute Items (Link Attributes to Products)
foreach ($jsonData['products'] as $prodData) {
    $product = $products[$prodData['id']];

    foreach ($prodData['attributes'] as $attrData) {
        $attribute = $attributes[$attrData['name']]; // Get the shared attribute

        foreach ($attrData['items'] as $itemData) {
            // Ensure attribute items are unique per product
            $existingItem = $entityManager->getRepository(AttributeItem::class)->findOneBy([
                'displayValue' => $itemData['displayValue'],
                'product' => $product
            ]);

            if (!$existingItem) {
                $item = new AttributeItem(
                    uniqid(),
                    $itemData['displayValue'],
                    $itemData['value'],
                    $attribute,
                    $product
                );
                $entityManager->persist($item);
            }
        }
    }
}
$entityManager->flush();
echo "✅ Attribute items linked to products successfully.\n";

// Step 5: Insert Prices & Currencies
$currencies = [];
foreach ($jsonData['products'] as $prodData) {
    $product = $products[$prodData['id']];

    foreach ($prodData['prices'] as $priceData) {
        $currencyLabel = $priceData['currency']['label'];

        // Store and reuse currency instances
        if (!isset($currencies[$currencyLabel])) {
            $currency = new Currency($currencyLabel, $priceData['currency']['symbol']);
            $entityManager->persist($currency);
            $currencies[$currencyLabel] = $currency;
        } else {
            $currency = $currencies[$currencyLabel];
        }

        $price = new Price($priceData['amount'], $currency, $product);
        $entityManager->persist($price);
    }
}
$entityManager->flush();
echo "✅ Prices imported successfully.\n";

echo "🎉 Data successfully imported into the database!\n";
