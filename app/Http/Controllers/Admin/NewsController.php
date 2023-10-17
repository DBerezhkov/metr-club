<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.news.index', [
            'news' => $news,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'annotation' => 'required|string',
            'article_text' => 'required|string'
        ]);


        $dom = new \DomDocument();
        $dom->loadHtml("\xEF\xBB\xBF" . $validated['article_text'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $image_file = $dom->getElementsByTagName('img');

        foreach($image_file as $key => $image) {
            $data = $image->getAttribute('src');
            $filename = $image->getAttribute('data-filename');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);

            $img_data = base64_decode($data);
            $image_name = "/img/news/" . time() . '_' . $filename;
            $path = public_path() . $image_name;
            file_put_contents($path, $img_data);

            $image->removeAttribute('src');
            $image->removeAttribute('data-filename');
            $image->setAttribute('src', $image_name);
        }
        $validated['article_text'] = html_entity_decode($dom->saveHTML());

        $news = new News($validated);
        $news->save();
        return redirect()->back()->withSuccess('Новость успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::find($id);
        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $news->update($request->except(['files']));

        return redirect()->back()->withSuccess('Новость успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $news = News::find($id);
        $news->delete();
        return redirect()->back();
    }
}
