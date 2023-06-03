<?php

namespace Modules\Posts\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Posts\Http\Requests\StorePostCategoryRequest;
use Modules\Posts\Http\Requests\UpdatePostCategoryRequest;
use Modules\Posts\Models\PostCategory;
use Modules\Posts\Repositories\Contracts\PostCategoryRepositoryInterface;
use Exception;

class PostCategoryController extends Controller
{
    /**
     * @var PostCategory
     */
    protected $repository;

    /**
     * PostCategoryController constructor.
     * @param PostCategoryRepositoryInterface $repository
    */
    public function __construct(
        PostCategoryRepositoryInterface $repository
    ){
        // $this->authorizeResource(PostCategory::class);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->repository->paginate(30);
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Posts\Http\Requests\StorePostCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostCategoryRequest $request)
    {
        try {
            $dados = $this->repository->store($request->all());
            if($dados) {
                return response()->json(['success' => 'Cadastro realizado com sucesso!'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\Posts\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function show($postCategory)
    {
        try{
            $data = $this->repository
                ->findWhereFirst("id", $postCategory);
            return response()->json($data);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\Posts\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($postCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Posts\Http\Requests\UpdatePostCategoryRequest  $request
     * @param  \Modules\Posts\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostCategoryRequest $request, $postCategory)
    {
        try {
            $this->repository->update($postCategory, $request->all());
            return response()->json(['success' => 'Registro atualizado'],200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\Posts\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($postCategory)
    {
        try {
            $this->repository->delete($postCategory->id);
            return response()->json(['success' => 'Registro excluído!'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listAll(){
        try {
            $data = $this->repository->getAll();
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function filterPost($slug)
    {
        try {
            $data = $this->repository
                ->relationships('post', 'post.user', 'post.category')
                ->findSlug("slug", $slug);
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
