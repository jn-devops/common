<?php

use Spatie\LaravelData\{DataCollection, Optional};
use Homeful\Common\Classes\DocStamps;
use Homeful\Common\Enums\WorkArea;
use Homeful\Common\Classes\Amount;

it('has documents_path utility', function () {
    expect(documents_path('file.ext'))->toBeString();
});

test('default work area is HUC', function () {
    expect(WorkArea::default())->toBe(WorkArea::HUC);
});

dataset('doc stamps', function () {
    return [
        fn() => ['value' => 50000,    'guess_price' => 0.0],
        fn() => ['value' => 100000,   'guess_price' => 0.0],
        fn() => ['value' => 100001,   'guess_price' => 20.0],
        fn() => ['value' => 300000,   'guess_price' => 20.0],
        fn() => ['value' => 300001,   'guess_price' => 50.0],
        fn() => ['value' => 500000,   'guess_price' => 50.0],
        fn() => ['value' => 500001,   'guess_price' => 100.0],
        fn() => ['value' => 750000,   'guess_price' => 100.0],
        fn() => ['value' => 750001,   'guess_price' => 150.0],
        fn() => ['value' => 1000000,  'guess_price' => 150.0],
        fn() => ['value' => 1000001,  'guess_price' => 200.0],
        fn() => ['value' => 6000000,  'guess_price' => 200.0],
        fn() => ['value' => 9000000,  'guess_price' => 200.0],
    ];
});

test('doc stamps has price range', function (array $params) {
    $ds = new DocStamps($params['value']);
    expect($ds->getValue()->inclusive()->compareTo($params['value']))->toBe(Amount::EQUAL);
    expect($ds->getPrice()->inclusive()->compareTo($params['guess_price']))->toBe(Amount::EQUAL);
    expect(doc_stamps($params['value']))->toBe($params['guess_price']);
})->with('doc stamps');

test('validate json works', function () {
    $jsonString = '{"name": "John", "age": 30}';
    expect(validateJson($jsonString))->toBeTrue();
    $jsonString = '{"name": "John", xxxxx}';
    expect(validateJson($jsonString))->toBeFalse();
});

test('resolveOptionalCollection works', function () {
    $result = resolveOptionalCollection(null);
    expect($result)->toBeCollection()->toBeEmpty();
    $result = resolveOptionalCollection(Optional::create());
    expect($result)->toBeCollection()->toBeEmpty();
});

test('convertNumberToWords works', function () {
    $result = convertNumberToWords(111.25);
    expect($result)->toBe('ONE HUNDRED ELEVEN AND 25/100');
});
