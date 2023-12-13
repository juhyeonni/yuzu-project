<?php

namespace App\Repositories;

interface PostImageUploadRepositoryInterface
{
  public function uploadImages(array $images, string $id);
}
