<?php

namespace TradefiUBA\Http\Controllers\Admin;

use Illuminate\Http\Request;
use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\FAQ;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = FAQ::all();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'subject' => 'required',
            'body'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()->first()], 200);
        }
        $faq = new FAQ($request->all());
        if ($faq->save()) {
            return response()->json(['success' => true, 'message' => 'FAQ was saved successfully', 'data' => $faq], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'FAQ failed to save'], 500);
        }
    }

    public function destroy($id)
    {
        $faq = FAQ::find($id);
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ item was deleted successfully');
    }
}
