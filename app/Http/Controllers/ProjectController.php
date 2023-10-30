<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Services\ProjectService;
use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'projects' => $this->projectService->getAllProjectsPaginated()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        $this->projectService->create($request->validated());

        to_route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request)
    {   
        $this->projectService->update($request->id, $request->validated());

        to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'id' => ['required'],
        ]);
        $this->projectService->delete($request->id);

        return Redirect::to('/dashboard');
    }
}
