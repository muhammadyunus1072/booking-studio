<?php

namespace App\Repositories\MasterData\Product;

use App\Models\MasterData\Product;
use App\Repositories\MasterDataRepository;

class ProductRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return Product::class;
    }

    public static function datatable()
    {
        return Product::query();
    }
}
