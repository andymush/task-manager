<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::all();
        $projectId = $request->input('project_id');
        
        $query = Task::query()->orderBy('priority', 'asc');
        
        if ($projectId) {
            $query->where('project_id', $projectId);
        }
        
        $tasks = $query->get();
        
        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        // Get the highest priority value and add 1 for new task
        $maxPriority = Task::max('priority') ?? 0;

        Task::create([
            'name' => $request->name,
            'priority' => $maxPriority + 1,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task->update([
            'name' => $request->name,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        // Reorder priorities after deletion
        $this->reorderPriorities($task->project_id);

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Update the order of tasks.
     */
    public function updateOrder(Request $request)
    {
        $tasks = $request->input('tasks', []);
        
        foreach ($tasks as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Reorder task priorities.
     */
    private function reorderPriorities($projectId = null)
    {
        $query = Task::query()->orderBy('priority', 'asc');
        
        if ($projectId) {
            $query->where('project_id', $projectId);
        }
        
        $tasks = $query->get();
        
        foreach ($tasks as $index => $task) {
            $task->update(['priority' => $index + 1]);
        }
    }
}
