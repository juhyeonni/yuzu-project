<?php

// namespace App\Repositories\Eloquent;

// use App\Repositories\ImageUploadRepositoryInterface;

// class CommitImageUploadRepository extends BaseRepository implements
//   ImageUploadRepositoryInterface
// {
//   public function __construct($model)
//   {
//     parent::__construct($model);
//   }

//   public function uploadImage(array $validated)
//   {
//     $imageName = time() . "." . $validated["image"]->extension();

//     $validated["image"]->move(public_path("images"), $imageName);

//     return $validated["image"];
//   }
// }
