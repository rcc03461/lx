<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function apiGetTask( Task $task ){
        return $task->load(['job', 'client']);
    }

    public function apiSearch( ){

        $q = request()->get('q');
        $data = Task::with([
            // 'client',
            'job',
        ])
        ->where('title', 'like', "%$q%")
        ->orHasByNonDependentSubquery('job', fn($subq)=>$subq->where('job_code', 'like', "%$q%"))
        ->take(20)
        ->get();
        return $data;
    }

    public function index()
    {
        return Inertia::render('Tasks/List', [
            'tasks' => Task::orderByDesc('id')->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Task::create($request->validate([
            'title' => ['required', 'max:255'],
        ]));
        return redirect()->route('tasks.index');
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
