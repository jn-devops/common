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

    foreach ($mediaAttributes as $attribute => $expectedCollectionName) {
        expect(UploadFile::deriveCollectionNameFromAttribute($attribute))
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

    foreach ($mediaAttributes as $expectedAttribute => $collectionName) {
        expect(UploadFile::deriveAttributeFromCollectionName($collectionName))
            ->toBe($expectedAttribute);
    }
});
