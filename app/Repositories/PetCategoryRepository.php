<?php

namespace App\Repositories;

use App\Models\PetCategory;

class PetCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return PetCategory::class;
    }
}