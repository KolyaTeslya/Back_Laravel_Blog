<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // All Post
        $posts = Post::all();

        // Return Json Response
        return response()->json([
            'posts' => $posts
        ],200);
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
     * @param PostStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostStoreRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();

            // Create Post
            Post::create([
                'title' => $request->title,
                'image' => $imageName,
                'description' => $request->description
            ]);

            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            // Return Json Response
            return response()->json([
                'message' => "Post successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Post Detail
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'message'=>'Post Not Found.'
            ],404);
        }

        // Return Json Response
        return response()->json([
            'post' => $post
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostStoreRequest $request, $id)
    {
        try {
            // Find post
            $post = Post::find($id);
            if(!$post){
                return response()->json([
                    'message'=>'Post Not Found.'
                ],404);
            }

            $post->title = $request->title;
            $post->description = $request->description;

            if($request->image) {
                // Public storage
                $storage = Storage::disk('public');

                // Old image delete
                if($storage->exists($post->image))
                    $storage->delete($post->image);

                // Image name
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $post->image = $imageName;

                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }

            // Update Post
            $post->save();

            // Return Json Response
            return response()->json([
                'message' => "Post successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Detail
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'message'=>'Post Not Found.'
            ],404);
        }

        // Public storage
        $storage = Storage::disk('public');

        // Iamge delete
        if($storage->exists($post->image))
            $storage->delete($post->image);

        // Delete Post
        $post->delete();

        // Return Json Response
        return response()->json([
            'message' => "Post successfully deleted."
        ],200);
    }
}
