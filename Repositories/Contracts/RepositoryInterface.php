<?php

namespace Modules\Posts\Repositories\Contracts;

interface RepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function findWhere($column, $value);
    public function findWhereFirst($column, $value);
    public function relationships(...$relationships);
    public function paginate($totalPage = 30);
    public function store(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function orderBy($column, $order = 'DESC');
    public function search($column, $data);

}
