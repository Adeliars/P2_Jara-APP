<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB DITAMBAHKAN UNTUK TRANSACTION

class ProjectController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $projects = Project::where('owner_id', $userId)
            ->orWhereHas('members', fn($q) => $q->where('user_id', $userId))
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        // SRS-009: Validasi input dan Parameterized Query (Otomatis oleh Eloquent)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // SRS-007: Memulai Transaksi Atomik
        DB::beginTransaction();

        try {
            // Proses 1: Membuat project
            $project = Project::create([
                ...$validated,
                'owner_id' => auth()->id(),
            ]);

            // Proses 2: Memasukkan pembuat ke tabel anggota
            $project->members()->attach(auth()->id());

            // Jika kedua proses berhasil, simpan permanen
            DB::commit();

            return redirect()->route('projects.index')
                ->with('success', 'Project berhasil dibuat.');

        } catch (\Exception $e) {
            // Jika ada yang gagal, batalkan seluruh perubahan
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem, pembuatan project dibatalkan.']);
        }
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        // Memastikan hanya yang berwenang (owner) yang bisa menghapus
        $this->authorize('delete', $project);

        // SRS-008: Memulai Transaksi Atomik untuk penghapusan
        DB::beginTransaction();

        try {
            // Secara eksplisit menghapus relasi untuk memastikan proses atomik berjalan sempurna
            // (Meskipun di database sudah ada onDelete('cascade'))
            $project->members()->detach(); 
            
            // Hapus semua task yang terkait dengan project ini
            // Asumsi: Kamu memiliki relasi tasks() di model Project
            if (method_exists($project, 'tasks')) {
                $project->tasks()->delete();
            }

            // Hapus project utama
            $project->delete();

            // Simpan perubahan secara permanen
            DB::commit();

            return redirect()->route('projects.index')
                ->with('success', 'Project beserta seluruh tugas dan keanggotaannya berhasil dihapus.');

        } catch (\Exception $e) {
            // Jika penghapusan gagal di tengah jalan, kembalikan data seperti semula
            DB::rollBack();

            return back()->withErrors(['error' => 'Terjadi kesalahan sistem, penghapusan project dibatalkan.']);
        }
    }
}