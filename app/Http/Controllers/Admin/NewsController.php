<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $new = new News($request->all());
        if ($new->save()) {
            return redirect()->route('admin.news.index');
        }
    }

    public function show($id)
    {
        $news_item = News::find($id);
        // dd($news_item);
        return view('news.show', compact('news_item'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $new = News::find($id);
        $new->delete();
        return redirect()->route('admin.news.index')->with('success', 'News Item was deleted successfully');
    }
}
