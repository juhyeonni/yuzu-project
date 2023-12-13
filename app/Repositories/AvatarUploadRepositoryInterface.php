<?php

namespace App\Repositories;
use Illuminate\Http\UploadedFile;

interface AvatarUploadRepositoryInterface
{
  public function uploadImage(UploadedFile $photo, string $id);
}
