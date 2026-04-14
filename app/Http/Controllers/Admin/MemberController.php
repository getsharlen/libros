<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        $members = User::query()
            ->where('role', 'siswa')
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q').'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if (! $request->expectsJson()) {
            return view('admin.members.index', compact('members'));
        }

        return response()->json($members);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.members.create');
    }

    public function store(StoreMemberRequest $request): JsonResponse|RedirectResponse
    {
        $payload = $request->validated();
        $payload['role'] = 'siswa';
        $payload['password'] = Hash::make($payload['password']);

        $member = User::create($payload);

        if (! $request->expectsJson()) {
            return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
        }

        return response()->json([
            'message' => 'Anggota berhasil ditambahkan.',
            'data' => $member,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member, Request $request): JsonResponse|View
    {
        if ($member->role !== 'siswa') {
            abort(404);
        }

        if (! $request->expectsJson()) {
            return view('admin.members.show', compact('member'));
        }

        return response()->json($member);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member): View
    {
        if ($member->role !== 'siswa') {
            abort(404);
        }

        return view('admin.members.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, User $member): JsonResponse|RedirectResponse
    {
        if ($member->role !== 'siswa') {
            abort(404);
        }

        $payload = $request->validated();

        if (! empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        } else {
            unset($payload['password']);
        }

        $member->update($payload);

        if (! $request->expectsJson()) {
            return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
        }

        return response()->json([
            'message' => 'Data anggota berhasil diperbarui.',
            'data' => $member,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member, Request $request): JsonResponse|RedirectResponse
    {
        if ($member->role !== 'siswa') {
            abort(404);
        }

        $member->delete();

        if (! $request->expectsJson()) {
            return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
        }

        return response()->json([
            'message' => 'Anggota berhasil dihapus.',
        ]);
    }
}
