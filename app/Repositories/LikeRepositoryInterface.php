<?php

namespace App\Repositories;

interface LikeRepositoryInterface
{
  public function likeToggle(string $id);
}
