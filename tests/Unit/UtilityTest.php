<?php

use Homeful\Common\Enums\WorkArea;

it('has documents_path utility', function () {
    expect(documents_path('file.ext'))->toBeString();
});

test('default work area is HUC', function () {
    expect(WorkArea::default())->toBe(WorkArea::HUC);
});
