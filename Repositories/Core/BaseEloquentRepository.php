<?php

namespace Modules\Posts\Repositories\Core;

use Modules\Posts\Repositories\Contracts\RepositoryInterface;

class BaseEloquentRepository implements RepositoryInterface
{
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function getAll()
    {
        return $this->entity->get();
    }

    public function getAllOrder($column, $order = 'DESC')
    {
        return $this->entity
            ->orderBy($column, $order)
            ->get();
    }

    public function findById($id)
    {
        return $this->entity->find($id);
    }

    public function findWhere($column, $value)
    {
        return $this->entity
            ->where($column, '=', $value);

    }

    public function findWhereFirst($column, $value)
    {
        return $this->entity
            ->where($column, $value)
            ->first();
    }

    public function paginate($totalPage = 30)
    {
        return $this->entity->paginate($totalPage);
    }

    public function store(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(int $id, array $data)
    {
        $entity = $this->findById($id);

        return $entity->update($data);
    }

    public function delete(int $id)
    {
        return $this->entity->find($id)->delete();
    }

    public function relationships(...$relationships)
    {
        $this->entity = $this->entity->with($relationships);
        return $this;
    }

    public function orderBy($column, $order = 'DESC')
    {
        $this->entity = $this->entity->orderBy($column, $order);
        return $this;
    }

    public function search($column, $data)
    {
        return $this->entity
            ->where($column,"like","%".$data."%")
            ->paginate();
    }

    public function searchActive($column, $data, $columnActive, $value)
    {
        return $this->entity
            ->where($column,"like","%".$data."%")
            ->where($columnActive, $value)
            ->paginate();
    }

    public function resolveEntity()
    {
        if(!method_exists($this, 'entity')){
            throw new NotEntityDefined;
        }

        return app($this->entity());
    }
}
