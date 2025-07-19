<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where("user_id", request()->user()->id)
        ->orderBy("id", "DESC")->paginate(2);
        return view("blog.index",[
            "blogs" => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required| string",
            "description" => "required| string",
            "banner_image" => "required| image"
        ]);
        $data["user_id"] = request()->user()->id;   
        
        if($request->hasFile('banner_image')) {
            $data["banner_image"] = $request->file("banner_image")->store("blogs", "public");
        }

        Blog::create($data);

        return to_route("blog.index")->with("success", "Blog Created Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view("blog.show", [
            "blog" => $blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view("blog.edit", [
            "blog" => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
