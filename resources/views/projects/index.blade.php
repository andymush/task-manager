@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h2>Projects</h2>
        <div>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Add Project</a>
        </div>
    </div>

    <div class="list-group">
        @forelse($projects as $project)
            <div class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $project->name }}</h5>
                        <div class="text-muted small">
                            {{ $project->tasks->count() }} tasks
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}" class="btn btn-sm btn-outline-secondary">View Tasks</a>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure? This will delete all tasks in this project.')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">No projects found.</div>
        @endforelse
    </div>
@endsection