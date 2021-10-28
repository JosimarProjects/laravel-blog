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
        $data = $request->all();
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        return $this->repository->create($data);
    }

    public function delete($slug){
        return $this->repository->delete($slug);
    }

}



?>
