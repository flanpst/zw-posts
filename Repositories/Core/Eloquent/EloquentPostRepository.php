<?php

namespace Modules\Posts\Repositories\Core\Eloquent;

use Illuminate\Support\Str;
use Modules\Posts\Repositories\Contracts\PostRepositoryInterface;
use Modules\Posts\Repositories\Core\BaseEloquentRepository;

class EloquentPostRepository extends BaseEloquentRepository implements PostRepositoryInterface
{
        public function entity()
        {
                return Post::class;
        }

        public function index()
        {
                $entities = $this->entity()::with(['user', 'category'])
                                                ->paginate(30);

                $entities->getCollection()->transform(function ($entity) {
                        $entity->user->makeHidden(['created_at', 'updated_at']);
                        return $entity;
                });

                return $entities;
        }

        public function store(array $data): bool
        {
                $user = auth()->user();
                $dateConvert = date('Y-m-d H:i:s', strtotime($data['publication_date']));

                $modelData = [
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'resume' => $data['resume'],
                        'image' => $data['image'],
                        'banner' => $data['banner'],
                        'slug' => Str::slug($data['title'], '-'),
                        'post_category_id' => $data['post_category_id'],
                        'publication_date' => $dateConvert,
                        'user_id' => $user->id,
                        'post_status' => $data['post_status'],
                        'meta_title' => $data['meta_title'],
                        'meta_description' => $data['meta_description'],
                        'meta_tags' => $data['meta_tags']
                ];

                $model = new $this->entity();
                $model->fill($modelData);
                $model->save();

                return true;
        }


        public function update($id, $data)
        {
                $dateConvert = date('Y-m-d H:i:s', strtotime($data['publication_date']));

                $model = $this->entity::find($id);

                if ($model) {
                        $model->update([
                                'title' => $data['title'],
                                'content' => $data['content'],
                                'resume' => $data['resume'],
                                'image' => $data['image'],
                                'banner' => $data['banner'],
                                'slug' => Str::of($data['title'])->slug('-'),
                                'post_category_id' => $data['post_category_id'],
                                'publication_date' => $dateConvert,
                                'user_id' => $data['user_id'],
                                'post_status' => $data['post_status'],
                                'meta_title' => $data['meta_title'],
                                'meta_description' => $data['meta_description']
                        ]);
                }
        }

        public function homeList()
        {
                $dataAtual = now();

                $models = $this->entity->with('user', 'category')
                        ->where('post_status', 1)
                        ->where('publication_date', '<=', $dataAtual)
                        ->take(3)
                        ->get();

                return $models->count() === 3 ? $models : false;
        }

        public function postList()
        {
                return $this->entity->with('user', 'category')
                        ->where('post_status', 1)
                        ->latest()
                        ->paginate(30);
        }
}
