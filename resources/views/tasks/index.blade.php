@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h2>Tasks</h2>
        <div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add Task</a>
        </div>
    </div>

    <div class="mb-4">
        <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
            <div class="col-auto">
                <select name="project_id" class="form-select">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>

    <div id="task-list">
        @forelse($tasks as $task)
            <div class="sortable-task" data-id="{{ $task->id }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $task->name }}</h5>
                        <div class="text-muted small">
                            Priority: {{ $task->priority }}
                            @if($task->project)
                                | Project: {{ $task->project->name }}
                            @else
                                | No Project
                            @endif
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">No tasks found.</div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskList = document.getElementById('task-list');
            
            if (taskList) {
                const sortable = new Sortable(taskList, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function(evt) {
                        const taskIds = Array.from(taskList.querySelectorAll('.sortable-task'))
                            .map(el => el.getAttribute('data-id'));
                        
                        axios.post('{{ route('tasks.update-order') }}', {
                            tasks: taskIds,
                            _token: '{{ csrf_token() }}'
                        })
                        .then(response => {
                            if (response.data.success) {
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error updating task order:', error);
                        });
                    }
                });
            }
        });
    </script>
@endsection