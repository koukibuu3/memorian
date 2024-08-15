<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Task List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-end">
            <h1 class="font-bold text-2xl h-12"><img src="/Memorian.png" class="w-12 inline-block" />Memorian</h1>
            @if (session('error'))
            <div id="toast-danger" class="flex items-center w-full max-w-xs px-4 py-2 text-gray-500 bg-white rounded-lg shadow" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
            </div>
            @endif
            @if (session('success'))
            <div id="toast-success" class="flex items-center w-full max-w-xs px-4 py-2 text-gray-500 bg-white rounded-lg shadow" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">Item moved successfully.</div>
            </div>
            @endif
        </div>
        <form action="/tasks/{{ $task->id }}" method="post" class="p-8">
            @csrf
            @method('PUT')
            <div class="flex justify-between">
                <h2 class="font-bold text-xl">課題詳細</h2>

                <div class="flex text-gray-500 justify-center text-sm">
                    <a href="/tasks" class="border-gray-200 border rounded-md py-1 px-6 mx-2 hover:text-orange-500 hover:border-orange-500">Cancel</a>
                    <input type="submit" value="Save" class="border-gray-200 border rounded-md py-1 px-6 mx-2 hover:text-orange-500 hover:border-orange-500" />
                </div>
            </div>

            <div class="mt-6 border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Title</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <input type="text" name="title" id="title" autocomplete="title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-xs sm:leading-6 px-2" value="{{$task->title}}">
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Description</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-xs sm:leading-6 px-2">{{ $task->description }}</textarea>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Assignee</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <select id="assignee_id" name="assignee_id" autocomplete="assignee_id" class="block w-full rounded-md border-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-xs sm:leading-6 px-2">
                                <option value="">None User</option>
                                @foreach ($assignees as $assignee)
                                <option value="{{ $assignee->userId }}" @if ($task->assignee?->userId === $assignee->userId) selected @endif>{{ $assignee->name }}</option>
                                @endforeach
                            </select>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Priority</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <select id="priority" name="priority" autocomplete="priority" class="block w-full rounded-md border-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-xs sm:leading-6 px-2">
                                @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" @if ($task->priority->id === $priority->id) selected @endif>{{ $priority->label }}</option>
                                @endforeach
                            </select>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Parent task</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0 flex justify-between">
                            <select id="parent_id" name="parent_id" autocomplete="parent_id" class="block w-full rounded-md border-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-xs sm:leading-6 px-2">
                                <option value="">None Task</option>
                                @foreach ($tasks as $parentTask)
                                <option value="{{ $parentTask->id }}" @if ($task->parent?->id === $parentTask->id) selected @endif @if (count($task->children) !== 0) disabled @endif>{{ $parentTask->title }}</option>
                                @endforeach
                            </select>
                            @if ($task->parent)
                            <div class="ml-4 flex-shrink-0 text-sm my-2 mx-5">
                                <a href="/tasks/{{ $task->parent->id }}" class="font-medium text-gray-500 hover:text-orange-500">Detail</a>
                            </div>
                            @endif
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Sub tasks</dt>
                        <dd class="mt-2 text-xs text-gray-900 sm:col-span-2 sm:mt-0">
                            @if (count($task->children) !== 0)
                            <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                @foreach ($task->children as $child)
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path d="M224,48V208a16,16,0,0,1-16,16H136a8,8,0,0,1,0-16h72V48H48v96a8,8,0,0,1-16,0V48A16,16,0,0,1,48,32H208A16,16,0,0,1,224,48ZM125.66,154.34a8,8,0,0,0-11.32,0L64,204.69,45.66,186.34a8,8,0,0,0-11.32,11.32l24,24a8,8,0,0,0,11.32,0l56-56A8,8,0,0,0,125.66,154.34Z"></path></svg>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span class="truncate font-medium">{{ $child->title }}</span>
                                            <span class="flex-shrink-0 text-gray-400">{{ $child->assignee?->name }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="/tasks/{{ $child->id }}" class="font-medium text-gray-500 hover:text-orange-500">Detail</a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Histories</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <ul>
                                @foreach ([1, 2, 3] as $history)
                                <li class="flex"><dt class="font-bold pr-2">2024-08-14 23:55</dt><dd>hoge</dd></li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>
                </dl>
            </div>
        </form>
    </div>

</body>

</html>
