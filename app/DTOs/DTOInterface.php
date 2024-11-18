<?php 

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

interface DTOInterface
{
    public static function fromRequest(array $array);

    public static function fromModel(Model $model);

    public function toArray(): array;
}