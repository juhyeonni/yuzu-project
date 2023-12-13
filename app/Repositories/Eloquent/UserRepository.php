<?php

namespace App\Repositories\Eloquent;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  public function __construct(User $model)
  {
    parent::__construct($model);
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
    $record = $this->model->find($id);

    return $record->update($data);
  }

  public function findByUsername(string $username)
  {
    return $this->model->where("username", $username)->firstOrFail();
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
