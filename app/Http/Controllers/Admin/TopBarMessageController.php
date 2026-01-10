<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopBarMessage;
use Illuminate\Http\Request;

class TopBarMessageController extends Controller
{
    public function index()
    {
        return view('admin.topbar_messages.index');
    }

    public function data(Request $request)
    {
        // DataTables server-side básico (sin Yajra)
        $draw   = (int) $request->input('draw');
        $start  = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $searchValue = $request->input('search.value');

        $query = TopBarMessage::query();

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%{$searchValue}%")
                  ->orWhere('content_html', 'like', "%{$searchValue}%");
            });
        }

        $total = TopBarMessage::count();
        $filtered = $query->count();

        $items = $query
            ->orderByDesc('id')
            ->skip($start)
            ->take($length)
            ->get();

        $data = $items->map(function ($m) {
            return [
                'id'        => $m->id,
                'title'     => $m->title ?? '—',
                'status'    => $m->is_active ? 1 : 0,
                'priority'  => $m->priority,
                'starts_at' => $m->starts_at?->format('Y-m-d H:i') ?? '—',
                'ends_at'   => $m->ends_at?->format('Y-m-d H:i') ?? '—',
                'action'    => '', // lo renderizamos en JS como en tu ejemplo
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('admin.topbar_messages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['nullable', 'string', 'max:255'],
            'content_html' => ['required', 'string'],
            'starts_at'    => ['nullable', 'date'],
            'ends_at'      => ['nullable', 'date', 'after_or_equal:starts_at'],
            'priority'     => ['nullable', 'integer', 'min:0', 'max:999999'],
            'is_active'    => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['priority']  = $data['priority'] ?? 0;

        TopBarMessage::create($data);

        return redirect()
            ->route('admin.topbar_messages.index')
            ->with('success', __('cms.topbar_messages.created'));
    }

    public function edit(TopBarMessage $message)
    {
        return view('admin.topbar_messages.edit', compact('message'));
    }

    public function update(Request $request, TopBarMessage $message)
    {
        $data = $request->validate([
            'title'        => ['nullable', 'string', 'max:255'],
            'content_html' => ['required', 'string'],
            'starts_at'    => ['nullable', 'date'],
            'ends_at'      => ['nullable', 'date', 'after_or_equal:starts_at'],
            'priority'     => ['nullable', 'integer', 'min:0', 'max:999999'],
            'is_active'    => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['priority']  = $data['priority'] ?? 0;

        $message->update($data);

        return redirect()
            ->route('admin.topbar_messages.index')
            ->with('success', __('cms.topbar_messages.updated'));
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:top_bar_messages,id'],
            'status' => ['required', 'in:0,1'],
        ]);

        $message = TopBarMessage::findOrFail($validated['id']);
        $message->is_active = (int)$validated['status'] === 1;
        $message->save();

        return response()->json([
            'success' => true,
            'message' => __('cms.topbar_messages.status_updated'),
        ]);
    }

    public function destroy(TopBarMessage $message)
    {
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => __('cms.topbar_messages.deleted'),
        ]);
    }
}
