<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">タスク一覧</h2>
  </x-slot>

  @if(session('success'))
    <div class="mb-4 rounded bg-green-100 p-3 text-green-800">{{ session('success') }}</div>
  @endif

  <div class="mb-4">
    <a href="{{ route('tasks.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">新規作成</a>
  </div>

  <div class="space-y-2">
    @forelse($tasks as $task)
      <div class="rounded border p-3 flex items-center justify-between">
        <div>
          <a href="{{ route('tasks.show', $task) }}" class="font-semibold hover:underline">{{ $task->title }}</a>
          @if($task->is_done)
            <span class="ml-2 rounded bg-emerald-100 px-2 py-0.5 text-xs text-emerald-700">DONE</span>
          @endif
          <div class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($task->description, 80) }}</div>
          <div class="text-xs text-gray-400">作成: {{ $task->created_at->format('Y-m-d H:i') }}</div>
        </div>
        <div class="flex items-center gap-3">
          <form method="POST" action="{{ route('tasks.toggle', $task) }}">
            @csrf @method('PATCH')
            <button class="rounded bg-slate-100 px-3 py-1 text-sm hover:bg-slate-200">
              {{ $task->is_done ? '未完了へ' : '完了へ' }}
            </button>
          </form>
          <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:underline">編集</a>
          <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('削除しますか？')">
            @csrf @method('DELETE')
            <button class="text-red-600 hover:underline">削除</button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-gray-500">タスクがありません。</p>
    @endforelse
  </div>

  <div class="mt-4">{{ $tasks->links() }}</div>
</x-app-layout>
