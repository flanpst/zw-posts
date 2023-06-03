<?php

namespace Modules\Posts\Repositories\Contracts;


interface PostCategoryRepositoryInterface extends RepositoryInterface
{
    public function store(array $request);
    public function update(int $id, $data);
}
