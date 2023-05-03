<?php

namespace Modules\Posts\Repositories\Contracts;

use Modules\Posts\Repositories\Contracts\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function index();
    public function store(array $request);
    public function update(int $id, array $data);
    public function homeList();
}
