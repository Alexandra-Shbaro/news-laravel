<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    //enforcing admin authentication 
    public function __construct()
    {
        $this->middleware('is_admin')->only(['create_news', 'update_news', 'delete_news']);
    }

    //create news (only admins)
    public function create_news(Request $request ){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'age_restriction' => 'nullable|integer', 
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:10240', 
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'age_restriction' => $request->age_restriction,
            'attachment' => $attachmentPath,
        ]);

        return response()->json($news, 201);
    }

    //edit news (only admins)
    public function update_news(Request $request, News $news){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'age_restriction' => 'nullable|integer', 
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx|max:10240', 
        ]);

        $attachmentPath = $news->attachment;
        if ($request->hasFile('attachment')) {
            if ($attachmentPath && file_exists(storage_path('app/public/' . $attachmentPath))) {
                unlink(storage_path('app/public/' . $attachmentPath));
            }
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'age_restriction' => $request->age_restriction,
            'attachment' => $attachmentPath,
        ]);

        return response()->json($news, 200);
    }

    //delete news
    public function delete_news(News $news){

        if ($news->attachment && file_exists(storage_path('app/public/' . $news->attachment))) {
            unlink(storage_path('app/public/' . $news->attachment));
        }

        $news->delete();

        return response()->json(['message' => 'News deleted successfully'], 200);
    }
    
    //
    public function get_all_news(){
        $news= News::all();
        return response()->json($news);
    }

    //display a single news article 
    public function get_news($id){
        $news=News::findorFail($id);
        return response()->json($news);
    }
}
