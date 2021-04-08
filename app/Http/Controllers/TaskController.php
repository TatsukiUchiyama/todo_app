<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;

class TaskController extends Controller
{
    public function index(int $id)
    {
        $folders = Folder::all();
        
        $current_folder = Folder::find($id);

        // $tasks = Task::where('folder_id', $current_folder->id)->get();
        // リレーションを行なったので簡単に参照できる様になった
        $tasks = $current_folder->tasks()->get();


        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folder/{id}/tasks/create
     */

    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id,
        ]);
    }
    // viewsメソッドの第二引数にフォルダIDを渡すことでネストしている


    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

}