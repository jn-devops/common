<?php

namespace Homeful\Common\Enums;

enum UploadFile: string
{
    case IMAGE = 'images';
    case DOCUMENT = 'documents';
    case CODE = 'codes';
    case MOVIE = 'movies';

    /**
     * Dynamically derive the correct enum based on the attribute suffix.
     */
    public static function fromAttribute(string $attribute): self
    {
        foreach (self::cases() as $suffix) {
            $suffixString = ucfirst(rtrim($suffix->value, 's')); // e.g., 'images' -> 'Image'
            if (str_ends_with($attribute, $suffixString)) {
                return $suffix;
            }
        }

        throw new \InvalidArgumentException("No matching suffix found for attribute '{$attribute}'.");
    }

    /**
     * Derive the collection name from a given attribute.
     */
    public function deriveCollectionNameFromAttribute(string $attribute): string
    {
        // Find the base key by stripping the suffix
        $suffixString = ucfirst(rtrim($this->value, 's')); // e.g., 'images' -> 'Image'
        $baseKey = substr($attribute, 0, -strlen($suffixString));
        // Convert to snake_case and append suffix
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $baseKey)) . '-' . $this->value;
    }

    /**
     * Derive the attribute from the given collection name.
     */
    public static function deriveAttributeFromCollectionName(string $collectionName): string
    {
        foreach (self::cases() as $suffix) {
            if (str_ends_with($collectionName, '-' . $suffix->value)) {
                $baseValue = str_replace('-' . $suffix->value, '', $collectionName);
                // Convert to camelCase and append suffix
                return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $baseValue)))) . ucfirst(rtrim($suffix->value, 's'));
            }
        }

        throw new \InvalidArgumentException("The suffix in collection name '{$collectionName}' is not recognized.");
    }
}
