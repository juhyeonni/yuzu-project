<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
  public function paginate($perPage);
  public function search(string $keyword);
}
