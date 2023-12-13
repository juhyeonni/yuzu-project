<?php

namespace App\Repositories\Eloquent;

use App\Repositories\AvatarUploadRepositoryInterface;
use Illuminate\Http\UploadedFile;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

class AvatarUploadRepository extends BaseRepository implements
  AvatarUploadRepositoryInterface
{
  public function __construct(User $model)
  {
    parent::__construct($model);
  }

  public function uploadImage(UploadedFile $photo, string $id)
  {
    $photoName = date("ymdHis") . "_" . uniqid() . "." . $photo->extension();
    $path = $photo->storeAs("public/avatars/" . date("ymd"), $photoName);
    $storedPath = Storage::url($path);

    $this->model->find($id)->update([
      "photo" => $storedPath,
    ]);

    return $storedPath;
  }

  public function uploadImages(array $photos, string $id)
  {
    // not used
    $storedPaths = [];

    foreach ($photos as $photo) {
      $storedPaths[] = $this->uploadImage($photo, $id);
    }

    return $storedPaths;
  }
}
