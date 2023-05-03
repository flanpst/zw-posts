<?php

namespace Modules\Posts\Repositories\Contracts;

use Modules\Posts\Repositories\Contracts\PostRepositoryInterface;

interface PostCategoryRepositoryInterface extends PostRepositoryInterface
{
    public function store(array $request);
    public function update(int $id, array $data);
}
