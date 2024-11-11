<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999',
        ]);
        
        $filenameSimpan = 'noimage.png';

        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            // $smallFilename = "small_{$basename}.{$extension}";
            // $mediumFilename = "medium_{$basename}.{$extension}";
            // $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('public/images', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
        //dd($request->input());
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->picture = $filenameSimpan;
        // $post->small_picture = $smallFilename;
        // $post->medium_picture = $mediumFilename;
        // $post->large_picture = $largeFilename;
        $post->save();

        return redirect()->route('gallery.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->description = $request->input('description');

        // Cek apakah ada gambar baru yang di-upload
        if ($request->hasFile('picture')) {
            // Hapus gambar lama dari storage
            if ($post->picture != 'noimage.png' && Storage::exists('public/images/' . $post->picture)) {
                Storage::delete('public/images/' . $post->picture);
            }

            // Proses gambar baru
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('public/images', $filenameSimpan);

            $post->picture = $filenameSimpan;
        }

        $post->save();
        return redirect()->route('gallery.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // Hapus gambar dari storage
        if ($post->picture != 'noimage.png' && Storage::exists('public/images/' . $post->picture)) {
            Storage::delete('public/images/' . $post->picture);
        }

        $post->delete();
        return redirect()->route('gallery.index')->with('success', 'Data berhasil dihapus');
    }
}
