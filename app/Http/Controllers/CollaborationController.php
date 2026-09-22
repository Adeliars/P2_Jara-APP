<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Auth;

class CollaborationController extends Controller
{
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        
        $users = User::where(
            'id',
            '!=',
            Auth::id()
        )->get();
        return view(
            'member',
            compact('project','users')
        );
    }

    public function addMember(Request $request, $projectId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $project = Project::findOrFail($projectId);

        if (!$project->isOwnedBy(Auth::id())) {
            abort(403, 'Anda tidak memiliki akses');
        }

        $project->members()->attach(
            $request->user_id
        );

        return back()->with(
            'success',
            'Anggota berhasil ditambahkan'
        );
    }
}