<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Task List | Memorian</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="font-bold text-2xl h-12"><img src="/Memorian.png" class="w-12 inline-block" />Memorian</h1>
        <div class="p-8">
            <div class="flex justify-between text-sm">
                <h2 class="font-bold text-xl">課題一覧</h2>
                <a href="{{ route('tasks.create') }}" class="text-gray-500 border-gray-200 border rounded-md py-1 px-6 mx-2 hover:text-orange-500 hover:border-orange-500">
                    Create new task
                </a>
            </div>
            <ul role="list" class="divide-y divide-gray-100 my-4">
                @foreach ($tasks as $task)
                <li class="flex justify-between gap-x-6 py-5 text-gray-900">
                    <div class="flex min-w-0 gap-x-4">
                        <a href="{{ route('tasks.show', $task->id) }}" class="flex min-w-0 gap-x-4 hover:text-orange-500">
                            <div class="min-w-0 flex-auto">
                                <p class="text-md font-semibold leading-6">{{ $task->title }}</p>
                                <p class="mt-1 truncate text-xs leading-5">{{ $task->description }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-md leading-6">{{ $task->assignee?->name ?? 'None User' }}</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">{{ $task->updatedAt }}</time></p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</body>

</html>
