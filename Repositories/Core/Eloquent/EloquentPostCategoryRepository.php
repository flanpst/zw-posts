<?php

namespace Modules\Posts\Repositories\Core\Eloquent;

use Illuminate\Support\Str;
use Modules\Posts\Models\PostCategory;
use Modules\Posts\Repositories\Contracts\PostCategoryRepositoryInterface;
use Modules\Posts\Repositories\Core\BaseEloquentRepository;

class EloquentPostCategoryRepository extends BaseEloquentRepository implements PostCategoryRepositoryInterface
{
    public function entity()
    {
        return PostCategory::class;
    }

    public function store(array $data): bool
    {
        $model = new $this->entity();
        $model->fill([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-'),
        ])->save();

        return true;
    }


    public function update(int $id, array $data): bool
    {
        $model = $this->entity::find($id);
        if($model){
            $model->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name'], '-')
            ]);

            return true;
        }
    }


}
