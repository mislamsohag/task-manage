<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{
    
    function TaskPage(){
        return view('pages.task-page');
    }


    // Task Store/create
    function taskCreate(Request $request){
        $user_id=$request->header('id');
        $img=$request->file('img');

        // dd($request->file('img'));

        // image name make
        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="images/tasks/{$img_name}";

        //image upload on local folder
        $img->move(public_path('images/tasks/'),$img_name);

        return Task::create([
            'user_id'=>$user_id,
            'task_name'=>$request->input('task_name'),
            'description'=>$request->input('description'),
            'img_url'=>$img_url
        ],201);

    }

    // All Tasks
    function TaskList(Request $request){
        $user_id=$request->header('id');
        return Task::where('user_id', $user_id)->get();
    }

    // Task Delete
    function TaskDelete(Request $request){
        $user_id=$request->header('id');
        $task_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);

        return Task::where('user_id', $user_id)->where('id',$task_id)->delete();
    }

    // Single Product
    function SingleTask(Request $request){
        $user_id=$request->header('id');
        // dd($user_id);
        $task_id=$request->input('id');       

        return Task::where('user_id', $user_id)->where('id', $task_id)->first();
    }

    // Task Update
    function TaskUpdate(Request $request){
        $user_id=$request->header('id');
        $task_id=$request->input('id');

        if($request->hasFile('img')){

            $img=$request->file('img');

            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="images/tasks/{$img_name}";

            $img->move(public_path('images/tasks'),$img_name);

            // delete old image
            $file_path=$request->input('file_path');
            File::delete($file_path);

            return Task::where('user_id', $user_id)->where('id', $task_id)->update([
                'task_name'=>$request->input('task_name'),
                'description'=>$request->input('description'),                
                'img_url'=>$img_url
            ]);

        }else{

            return Task::where('user_id', $user_id)->where('id', $task_id)->update([
                'task_name'=>$request->input('task_name'),
                'description'=>$request->input('description')
            ]);
        }
    }
}
