<?php

namespace App\Livewire\Admin\Task;

use App\Enums\PriorityTask;
use App\Events\TaskStatusUpdated;
use App\Jobs\NotifyUsersOfHighPriorityTask;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
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

    public function editRow(Task $task)
    {
        $this->editTask = $task->id;
        $this->title = $task->title;
        $this->end_date = $task->end_date;
        $this->description = $task->description;
        $this->priority = $task->priority;
        $this->status = $task->status;
    }

    public function saveTask()
    {
        $this->validate();

        try {
            $task = Task::create([
                'title' => $this->title,
                'description' => $this->description,
                'end_date' => $this->end_date,
                'priority' => $this->priority,
                'status' => $this->status,
            ]);

            if ($this->priority === PriorityTask::High->value) {
                NotifyUsersOfHighPriorityTask::dispatch($task);
            }
            
            broadcast(new TaskStatusUpdated($task))->toOthers();

            session()->flash('message', 'تسک جدید ایجاد شد');

        } catch (\Exception $e) {
            session()->flash('error', 'مشکلی در ثبت تسک جدید پیش آمد.');
            Log::error('Error saving task', ['error' => $e->getMessage()]);
        }

        
    }

    public function updateRow(Task $task)
    {
        $this->validate();

        try {
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
                'end_date' => $this->end_date,
                'priority' => $this->priority,
                'status' => $this->status,
            ]);

            $this->editTask = null;

            if ($this->priority === PriorityTask::High->value) {
                NotifyUsersOfHighPriorityTask::dispatch($task);
            }

            broadcast(new TaskStatusUpdated($task))->toOthers();

            session()->flash('message', 'تسک مورد نظر ویرایش شد');

        } catch (\Exception $e) {
            session()->flash('error', 'مشکلی در ویرایش تسک پیش آمد.');
            Log::error('Error updating task', ['error' => $e->getMessage()]);
        }

        $this->reset('title', 'description', 'end_date', 'priority', 'status');
    }

    public function getListeners()
    {
        return ['taskUpdated' => '$refresh'];
    }
}
