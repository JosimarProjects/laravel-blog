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

    public function getAll(){
        return $this->repository->getAll()->sortByDesc("updated_at");
    }

    public function getById($slug){

        return $this->repository->find($slug);
    }

    public function create($request){
        $newImageName = uniqid(). '-' .$request->title . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);
        $slug = $this->repository->createSlug( $request->title);
        $request->merge(['slug' => $slug]);
        $request->merge(['image_path' => $newImageName]);
        $request->merge(['user_id' => auth()->user()->id]);
        return $this->repository->create($request->toArray());
    }

    public function delete($slug){
        return $this->repository->delete($slug);
    }

}



?>
