<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseModel extends Model
{
    public function findBy(string $where, $value): Collection|array
    {
        return $this::query()
            ->where($where, '=', $value)
            ->limit(1)
            ->get();
    }
}
