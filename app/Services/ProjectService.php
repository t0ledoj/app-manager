<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    private ProjectRepository $projectRepository;

    public function __construct(ProjectRepository $projectRepository) {
        $this->projectRepository = $projectRepository;
    }

    public function create($data)
    {
        try {
            return $this->projectRepository->create($data);
            
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function update(int $id, array $data)
    {
        $project = $this->projectRepository->find($id);

        if ($project) {
            $project->update($data);
            return $project;
        }

        return null;
    }
    
    public function delete($id)
    {
        try {
            return $this->projectRepository->delete($id);
            
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function getAllProjectsPaginated()
    {
        return $this->projectRepository->getAllProjectsPaginated();
    }
}
