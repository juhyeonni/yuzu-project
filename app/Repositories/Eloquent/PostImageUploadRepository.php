<?php

namespace App\Repositories\Eloquent;

use App\Models\PostImage;
use App\Repositories\PostImageUploadRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PostImageUploadRepository extends BaseRepository implements
  PostImageUploadRepositoryInterface
{
  public function __construct(PostImage $model)
  {
    parent::__construct($model);
  }

  public function uploadImages(array $images, string $id)
  {
    foreach ($images as $image) {
      $imageName = date("ymdHis") . "_" . uniqid() . "." . $image->extension();
      $path = $image->storeAs("public/post_images/" . date("ymd"), $imageName);
      $storedPath = Storage::url($path);

      $this->model->create([
        "url" => $storedPath,
        "post_id" => $id,
      ]);
    }
  }
}
