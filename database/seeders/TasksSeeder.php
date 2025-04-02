<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the project IDs
        $workProject = Project::where('name', 'Work')->first();
        $personalProject = Project::where('name', 'Personal')->first();

        if (!$workProject || !$personalProject) {
            // if projects don't exist, make sure ProjectsSeeder runs first
            $this->command->info('Please run ProjectsSeeder first!');
            return;
        }

        // Create tasks for Work project
        Task::create([
            'name' => 'Complete quarterly report',
            'priority' => 1,
            'project_id' => $workProject->id,
        ]);

        Task::create([
            'name' => 'Schedule team meeting',
            'priority' => 2,
            'project_id' => $workProject->id,
        ]);

        Task::create([
            'name' => 'Update project documentation',
            'priority' => 3,
            'project_id' => $workProject->id,
        ]);

        // Create tasks for Personal project
        Task::create([
            'name' => 'Buy groceries',
            'priority' => 1,
            'project_id' => $personalProject->id,
        ]);

        Task::create([
            'name' => 'Go to the gym',
            'priority' => 2,
            'project_id' => $personalProject->id,
        ]);

        // Create tasks with no project
        Task::create([
            'name' => 'Read a book',
            'priority' => 1,
            'project_id' => null,
        ]);
    }
}