<?php

namespace Modules\Posts\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Posts\Http\Requests\StorePostRequest;
use Modules\Posts\Http\Requests\UpdatePostRequest;
use Modules\Posts\Models\Post;
use Modules\Posts\Repositories\Contracts\PostRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $repository;

    /**
     * PostController constructor.
     * @param PostRepositoryInterface $repository
    */
    public function __construct(
        PostRepositoryInterface $repository
    ){
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
            return response()->json($this->repository->index());
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
     * @param  \Modules\Posts\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
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
     *
     */
    public function show($post)
    {
        try{
            $data = $this->repository
                ->findWhereFirst("id", $post);
            return response()->json($data);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Posts\Http\Requests\UpdatePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $post)
    {
        try {
            $this->repository->update($post, $request->all());
            return response()->json(['success' => 'Registro atualizado'],200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        try {
            $this->repository->delete($post->id);
            return response()->json(['success' => 'Registro excluído!'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadImages(Request $request){
        if($request->file()){

            $image = $request->all();

            if(array_keys($image)[0] == 'avatar'){
                $imageName = $image['avatar']->getClientOriginalName();
                $image['avatar']->move(public_path('storage/post/images'), $imageName);
            }

            if(array_keys($image)[0] == 'banner'){
                $bannerName = $image['banner']->getClientOriginalName();
                $image['banner']->move(public_path('storage/post/images'), $bannerName);
            }

            return true;

        }

        return false;
    }

    public function home(){
        try {
            $data = $this->repository
                ->orderBy('id', 'desc')
                ->homeList();
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function postDetails($slug)
    {
        try{
            $data = $this->repository
                ->relationships('user.profile', 'category')
                ->findSlug("slug", $slug);
            return response()->json($data);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function postPage()
    {
        try {
            $data = $this->repository->postList();
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
