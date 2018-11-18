<?php

namespace App\Http\Controllers;
 
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function destroy($id,$planId)
    {
        $cmt = Comment::find($id);
        $cmt->delete(); 
        return redirect()->route('plans.show',$planId); //có thể sửa nếu cần thiết
    }

    public function edit(Request $request, $id)
    {
        $cmt = Comment::find($id);
        $cmt->content = $request->$id;
        $cmt->save();

        return redirect()->route('plans.show', $cmt->plan_id);
        // dd($request->$id);
    }
 
    public function store(Request $request)
    {
        // dd($request); 
        $string = "";
        $files = $request->file('upImage');
        if($request->srcImage == null && $request->comment == null && $request->hasFile('upImage') == null){
            return redirect()->route('plans.show', $request->plan_id);
        }
        if($request->srcImage != null){
            $rawData        = $request->srcImage;
            $filteredData   = explode(',', $rawData);
            $unencoded      = base64_decode($filteredData[1]);
            $randomName = rand(0, 99999);;


            $rs = file_put_contents('images/comments/'.$randomName.'.png', $unencoded);

            $string = $randomName.'.png';
            //dd($string);
        }

        if($request->hasFile('upImage')){
            foreach ($files as $img) {
                $name = Comment::all()->count().'_'.$img->getClientOriginalName();
                // var_dump($name);
                $img->move('images/comments', $name);

                if ($string == "") {
                    $string = $name;
                } else {
                    $string = $string . ', ' . $name;
                }
            }
            //dd($string);
        }

        if($request->hasFile('upImage') || $request->srcImage != null || $request->comment != null){
            $comment = new Comment;

            $comment->plan_id          = $request->plan_id;
            $comment->user_id          = Auth::user()->id;
            $comment->checkin_location = $request->name_place;
            $comment->content          = $request->comment;
            $comment->picture          = $string;
            $comment->parent_id        = $request->parent_id;

            $comment->save();
        }

        return redirect()->route('plans.show', $comment->plan_id);
    }
}
