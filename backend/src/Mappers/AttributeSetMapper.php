<?php

namespace App\Mappers;

class AttributeSetMapper extends BaseMapper
{
    public static function map($data): array
    {
        // Group attribute items by attribute ID
        $groupedAttributes = [];

        foreach ($data as $attributeItem) {
            $attribute = $attributeItem->getAttribute();
            $attributeId = $attribute->getName();

            if (!isset($groupedAttributes[$attributeId])) {
                $groupedAttributes[$attributeId] = [
                    'id' => $attributeId,
                    'name' => $attribute->getName(),
                    'type' => $attribute->getType(),
                    'items' => [],
                    '__typename' => 'AttributeSet',
                ];
            }

            // Collect attribute items
            $groupedAttributes[$attributeId]['items'][] = $attributeItem;
        }

        // Map items using AttributeItemMapper
        foreach ($groupedAttributes as &$attributeSet) {
            $attributeSet['items'] = AttributeItemMapper::map($attributeSet['items']);
        }

        return array_values($groupedAttributes); // Reset array keys before returning
    }
}
