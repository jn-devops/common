<?php

it('has documents_path utility', function () {
    expect(documents_path('file.ext'))->toBeString();
});
