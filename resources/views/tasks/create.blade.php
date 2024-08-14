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
        </div>
        <form action="/tasks" method="post" class="p-8">
            @csrf
            <div class="flex justify-between">
                <h2 class="font-bold text-xl">新規課題登録</h2>

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
                            <input type="text" name="title" id="title" autocomplete="title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-xs sm:leading-6 px-2">
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Description</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-xs sm:leading-6 px-2"></textarea>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Assignee</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <select id="assignee_id" name="assignee_id" autocomplete="assignee_id" class="block w-full rounded-md border-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-xs sm:leading-6 px-2">
                                <option value="" selected>None User</option>
                                @foreach ($assignees as $assignee)
                                <option value="{{ $assignee->userId }}">{{ $assignee->name }}</option>
                                @endforeach
                            </select>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Priority</dt>
                        <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <select id="priority" name="priority" autocomplete="priority" class="block w-full rounded-md border-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-xs sm:leading-6 px-2">
                                @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" @if (3 === $priority->id) selected @endif>{{ $priority->label }}</option>
                                @endforeach
                            </select>
                        </dd>
                    </div>
                    <?php /*
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Parent task</dt>
                        <dd class="mt-2 text-xs text-gray-900 sm:col-span-2 sm:mt-0">
                            <select id="parent_id" name="parent_id" autocomplete="parent_id" class="block w-full rounded-md border-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-xs sm:leading-6 px-2">
                                <option value="" selected>None</option>
                                @foreach ($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                        </dd>
                    </div>
                    */ ?>
                </dl>
            </div>
        </form>
    </div>

</body>

</html>
