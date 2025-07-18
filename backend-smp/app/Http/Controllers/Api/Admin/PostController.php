<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{
    /**
     * middleware
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['permission:posts.index'], only: ['index']),
            new Middleware(['permission:posts.create'], only: ['store']),
            new Middleware(['permission:posts.edit'], only: ['update']),
            new Middleware(['permission:posts.delete'], only: ['destroy']),
        ];
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user', 'category')->when(request()->search, function ($posts) {
            $posts = $posts->where('title', 'like', '%' . request()->search . '%');
        })->where('user_id', auth()->user()->id)->latest()->paginate(5);

        //append query string to pagination links
        $posts->appends(['search' => request()->search]);

        //return with Api Resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required|unique:posts',
            'category_id'   => 'required',
            'content'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('posts', $image->hashName(), 'public');

        $post = Post::create([
            'image'       => $image->hashName(),
            'title'       => $request->title,
            'slug'        => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'user_id'     => auth()->guard('api')->user()->id,
            'content'     => $request->content
        ]);


        if ($post) {
            //return success with Api Resource
            return new PostResource(true, 'Data Post Berhasil Disimpan!', $post);
        }

        //return failed with Api Resource
        return new PostResource(false, 'Data Post Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('category')->whereId($id)->first();

        if ($post) {
            //return success with Api Resource
            return new PostResource(true, 'Detail Data Post!', $post);
        }

        //return failed with Api Resource
        return new PostResource(false, 'Detail Data Post Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:posts,title,' . $post->id,
            'category_id'   => 'required',
            'content'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('public')->delete('posts/' . basename($post->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('posts', $image->hashName(), 'public');

            $post->update([
                'image'       => $image->hashName(),
                'title'       => $request->title,
                'slug'        => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'user_id'     => auth()->guard('api')->user()->id,
                'content'     => $request->content
            ]);
        }

        $post->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'user_id'     => auth()->guard('api')->user()->id,
            'content'     => $request->content
        ]);

        if ($post) {
            //return success with Api Resource
            return new PostResource(true, 'Data Post Berhasil Diupdate!', $post);
        }

        //return failed with Api Resource
        return new PostResource(false, 'Data Post Gagal Disupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //remove image
        Storage::disk('public')->delete('posts/' . basename($post->image));

        if ($post->delete()) {
            //return success with Api Resource
            return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new PostResource(false, 'Data Post Gagal Dihapus!', null);
    }
}