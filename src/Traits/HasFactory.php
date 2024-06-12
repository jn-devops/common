<?php

namespace Homeful\Common\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory as BaseHasFactory;
use Illuminate\Support\Str;

trait HasFactory
{
    use BaseHasFactory;

    protected static function newFactory()
    {
        $package = Str::before(get_called_class(), 'Models\\');
        $modelName = Str::after(get_called_class(), 'Models\\');
        $path = $package. 'Database\\Factories\\' . $modelName . 'Factory';

        return new $path;
    }
}
