<?php

namespace App\Http\Repositories;

use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;


 class Repository
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function createSlug($title)
    {
      return SlugService::createSlug(Post::class, 'slug',$title);
    }

    public function create(array $data )
    {
        
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    public function delete($slug)
    {
        $record =  $this->model->where('slug', $slug)->first();
        return $record->delete();
    }
}


?>
