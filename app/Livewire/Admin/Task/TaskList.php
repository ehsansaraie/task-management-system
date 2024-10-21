<?php

namespace App\Livewire\Admin\Task;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

class TaskList extends Component
{
    use WithPagination;

    #[Rule('required|min:3')]
    public $title;
    #[Rule('nullable')]
    public $description;
    #[Rule('date')]
    public $end_date;
    #[Rule('required')]
    public $priority;
    #[Rule('required')]
    public $status;

    public $editTask = null;
    protected $paginationTheme = 'bootstrap';

    #[Layout('admin.master')]
    public function render()
    {
        $tasks = Task::paginate();
        return view('livewire.admin.task.task-list', compact('tasks'));
    }

    public function editRow($task_id)
    {
        $task = Task::find($task_id);
        $this->editTask = $task_id;
        $this->title = $task->title;
        $this->end_date = $task->end_date;
        $this->description = $task->description;
        $this->priority = $task->priority;
        $this->status = $task->status;
    }

    public function saveTask()
    {
        $this->validate();

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'end_date' => $this->end_date,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        $this->reset('title', 'description', 'end_date', 'priority', 'status');

        session()->flash('message', 'تسک جدید ایجاد شد');        
    }

    public function updateRow($task_id)
    {
        $this->validate();

        $task = Task::find($task_id);
        $task = $task->update([
            'title' => $this->title,
            'description' => $this->description,
            'end_date' => $this->end_date,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        $this->editTask = null;
        $this->reset('title', 'description', 'end_date', 'priority', 'status');
        
        session()->flash('message', 'تسک مورد نظر ویرایش شد');
    }
}
