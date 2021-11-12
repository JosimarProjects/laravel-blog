<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use Carbon\Carbon;




class PostService
{
    /**
     * @var Repository $repository
     */


    /**
     * @param Repository $Repository
     * @return void
     */

    public Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll()->sortByDesc("updated_at");
    }

    public function getById($slug)
    {
        return $this->repository->find($slug);
    }

    public function requestMerge($request, $slug, $newImageName)
    {
        $data = $request;
        $data->merge(['slug' => $slug]);
        $data->merge(['image_path' => $newImageName]);
        $data->merge(['user_id' => auth()->user()->id]);
        return $data;
    }

    public function create($request)
    {
        $newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);
        $slug = $this->repository->createSlug($request->title);
        $data = $this->requestMerge($request, $slug, $newImageName);
        return $this->repository->create( $data->toArray());
    }

    public function delete($slug)
    {
        return $this->repository->delete($slug);
    }

    public function update($request, $slug)
    {
        $post = $this->repository->update($slug, $request);
    }
}
