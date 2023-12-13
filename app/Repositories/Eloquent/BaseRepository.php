<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function all()
  {
    return $this->model->all();
  }

  public function create(array $data)
  {
    return $this->model->create($data);
  }

  public function update(array $data, $id)
  {
    $record = $this->model->findOrFail($id);

    return $record->update($data);
  }

  public function delete($id)
  {
    return $this->model->destroy($id);
  }

  public function show($id)
  {
    return $this->model->findOrFail($id);
  }
}
