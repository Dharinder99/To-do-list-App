<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todos;

class TodoController extends Controller {
public function store(Request $request)
{
    $todo = Todo::create(['title' => $request->title, 'status' => 0]);
    return response()->json(['success' => true, 'todo' => $todo]);
}

public function updateStatus(Request $request, $id)
{
    $todo = Todo::find($id);
    if (!$todo) {
        return response()->json(['success' => false], 404);
    }

    $todo->status = $request->input('status') == 1;
    $todo->save();

    return response()->json(['success' => true]);
}

public function complete($id)
{
    $todo = Todo::find($id);
    $todo->status = 1;
    $todo->save();
    return response()->json(['success' => true]);
}

public function destroy($id)
{
    Todo::destroy($id);
    return response()->json(['success' => true]);
}
}
// class TodoController extends Controller
// {
//     public function index()
//     {
//         $todos = Todo::all();

//     // Return the view with the todos data
//     return view('index')->with('todos', $todos);
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'task' => 'required|unique:todos,task',
//         ]);

//         $todo = Todo::create(['task' => $request->task]);

//         return response()->json($todo);
//     }

//     public function updateStatus($id)
//     {
//         $todo = Todo::findOrFail($id);
//         $todo->completed = !$todo->completed;
//         $todo->save();

//         return response()->json($todo);
//     }

//     public function destroy($id)
//     {
//         $todo = Todo::findOrFail($id);
//         $todo->delete();

//         return response()->json(['message' => 'Task deleted successfully']);
//     }
// }
