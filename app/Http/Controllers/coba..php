public function update(Request $request, Blog $blog)
{
    $this->validate($request, [
        'title'     => 'required',
        'content'   => 'required'
    ]);

    //get data Blog by ID
    $blog = Blog::findOrFail($blog->id);

    if($request->file('image') == "") {

        $blog->update([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

    } else {

        //hapus old image
        Storage::disk('local')->delete('public/blogs/'.$blog->image);

        //upload new image
        $image = $request->file('image');
        $image->storeAs('public/blogs', $image->hashName());

        $blog->update([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

    }

    if($blog){
        //redirect dengan pesan sukses
        return redirect()->route('blog.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('blog.index')->with(['error' => 'Data Gagal Diupdate!']);
    }
}




