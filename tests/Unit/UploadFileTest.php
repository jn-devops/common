<?php

use Homeful\Common\Enums\UploadFile;

it('correctly derives collection names from attributes', function () {
    $mediaAttributes = [
        'idImage' => 'id-images',
        'voluntarySurrenderFormDocument' => 'voluntary_surrender_form-documents',
        'governmentId1Image' => 'government_id1-images',
        'contractToSellDocument' => 'contract_to_sell-documents',
        'movieClipMovie' => 'movie_clip-movies',
        'codeFileCode' => 'code_file-codes',
    ];

    foreach (array_keys($mediaAttributes) as $attribute) {
        $suffixEnum = UploadFile::fromAttribute($attribute);
        $expectedCollectionName = $mediaAttributes[$attribute];

        expect($suffixEnum->deriveCollectionNameFromAttribute($attribute))
            ->toBe($expectedCollectionName);
    }
});

it('correctly derives attributes from collection names', function () {
    $mediaAttributes = [
        'idImage' => 'id-images',
        'voluntarySurrenderFormDocument' => 'voluntary_surrender_form-documents',
        'governmentId1Image' => 'government_id1-images',
        'contractToSellDocument' => 'contract_to_sell-documents',
        'movieClipMovie' => 'movie_clip-movies',
        'codeFileCode' => 'code_file-codes',
    ];

    foreach (array_values($mediaAttributes) as $collectionName) {
        $expectedAttribute = array_search($collectionName, $mediaAttributes);

        expect(UploadFile::deriveAttributeFromCollectionName($collectionName))
            ->toBe($expectedAttribute);
    }
});
