<!-- Content area -->
<div class="content">

    <!-- Basic table -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">مدیریت وظایف</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        @if(session()->has('message'))
            <div class="alert alert-info">
                {{session('message')}}
            </div>
        @endif

        <div class="panel-body">

            <form wire:submit="saveTask" class="form-horizontal">
                <fieldset class="content-group">
                    <div class="form-group">

                        <div class="col-lg-6">
                            <label class="control-label">عنوان</label>
                            <input wire:model="title" type="text" class="form-control">
                            @error('title')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <label class="control-label">تاریخ پایان</label>
                            <input wire:model="end_date" type="text" class="form-control">
                            @error('end_date')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group">
                        
                        <div class="col-lg-6">
                            <label class="control-label">اولویت</label>
                            <select wire:model="priority" name="select" class="form-control">
                                <option value="{{App\Enums\PriorityTask::High}}">بالا</option>
                                <option value="{{App\Enums\PriorityTask::Average}}">متوسط</option>
                                <option value="{{App\Enums\PriorityTask::Down}}">پایین</option>
                            </select>
                            @error('priority')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <label class="control-label">وضعیت</label>

                            <select wire:model="status" name="select" class="form-control">
                                <option value="{{App\Enums\StatusTask::Progress}}">در حال انجام</option>
                                <option value="{{App\Enums\StatusTask::Completed}}">کامل شده</option>
                            </select>
                            @error('status')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">توضیحات</label>
                        <div class="col-lg-10">
                            <textarea wire:model="description" rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                            @error('description')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <div class="text-right">
              
                    @if ($editTask == null)
                    <button type="submit" class="btn btn-info">ثبت جدید</button>
                    @endif
                 
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>توضیحات</th>
                        <th>تاریخ پایان</th>
                        <th>اولیوت</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $index => $task)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$task->title}}</td>
                            <td>{{$task->description}}</td>
                            <td>{{$task->end_date}}</td>
                            <td>{{$task->priority}}</td>
                            <td>{{$task->status}}</td>
                            <td>
                                @if ($editTask == $task->id)
                                <button wire:click="updateRow({{$task->id}})" class="btn btn-warning">ویرایش شود</button>
                                @else
                                <button wire:click="editRow({{$task->id}})" class="btn btn-info">حالت ویرایش</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{$tasks->links()}}
        </div>
    </div>
    <!-- /basic table -->

</div>
<!-- /content area -->