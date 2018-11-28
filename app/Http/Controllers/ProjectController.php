<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\User;
use App\Models\Project;

class ProjectController extends AppBaseController
{
    /** @var  ProjectRepository */
    private $projectRepository;
    private $userRepository;

    public function __construct(ProjectRepository $projectRepo, UserRepository $userRepo)
    {
        $this->projectRepository = $projectRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the Project.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pageTitle = trans('project.title');
        $this->authorize('projectAdmin', Project::class);
        $this->projectRepository->pushCriteria(new RequestCriteria($request));
        $projects = $this->projectRepository->all();
        return view('projects.index', compact('pageTitle'))
            ->with('projects', $projects);
    }

    /**
     * Show the form for creating a new Project.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('projectAdmin', Project::class);
        return view('projects.create', [
            'listUser' => $this->userRepository->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param CreateProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectRequest $request)
    {
        $this->authorize('projectAdmin', Project::class);
        $input = $request->all();
        $responseData = [
            'status'  => STATUS_SUCCESS,
            'message' => null,
            'html'    => null
        ];
        try {
            if (isset($request->validator) && $request->validator->fails()) {
                session()->flashInput($request->all());
                $viewContent = \View::make('projects.create', [
                    'errors'   => $request->validator->messages(),
                    'listUser' => $this->userRepository->pluck('name', 'id')
                ])->render();
                $responseData['status'] = STATUS_ERROR;
                $responseData['html']   = $viewContent;
                return response()->json($responseData);
            }
            $project = $this->projectRepository->create($input);
            $viewContent             = \View::make('projects.table_row', ['project' => $project])->render();
            $responseData['message'] = trans('project.save_success');
            $responseData['html']    = $viewContent;
        } catch (\Exception $e) {
            $responseData['status']  = STATUS_ERROR;
            $responseData['message'] = $e->getMessage();
        }
        return response()->json($responseData);
    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->authorize('projectAdmin', Project::class);
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return response()->json(['status' => STATUS_ERROR, 'message' => trans('project.not_found')]);
        }
        $pageTitle = __('project.heading_update');
        return view('projects.edit', compact('pageTitle'))
            ->with('project', $project)
            ->with('listUser', $this->userRepository->pluck('name', 'id'));
    }

    /**
     * Update the specified Project in storage.
     *
     * @param  int              $id
     * @param UpdateProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectRequest $request)
    {
        $pageTitle = __('project.heading_update');
        $this->authorize('projectAdmin', Project::class);
        $responseData = [
            'status'  => STATUS_SUCCESS,
            'message' => null,
            'html'    => null
        ];
        try {
            $project = $this->projectRepository->findWithoutFail($id);
            $checkValid = true;
            $massageError = '';
            if (empty($project)) {
                $checkValid = false;
                $massageError = trans('project.not_found');
            } else {
                if (isset($request->validator) && $request->validator->fails()) {
                    session()->flashInput($request->all());
                    $checkValid = false;
                    $message = $request->validator->messages();
                }
            }
            if (!$checkValid) {
                $viewContent = \View::make('projects.edit', [
                    'errors'   => $message,
                    'listUser' => $this->userRepository->pluck('name', 'id'),
                    'project' => $project,
                    'pageTitle' => $pageTitle
                ])->render();
                $responseData['status'] = STATUS_ERROR;
                $responseData['html']   = $viewContent;
                return response()->json($responseData);
            }

            $project = $this->projectRepository->update($request->all(), $id);
            $viewContent             = \View::make('projects.table_row', ['project' => $project])->render();
            $responseData['message'] = trans('project.update_success');
            $responseData['id'] = $project->id;
            $responseData['html']    = $viewContent;
        } catch (\Exception $e) {
            $responseData['status']  = STATUS_ERROR;
            $responseData['message'] = $e->getMessage();
        }
        return response()->json($responseData);
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('projectAdmin', Project::class);
        $project = $this->projectRepository->findWithoutFail($id);

        if (empty($project)) {
            return response()->json(['status' => STATUS_ERROR, 'message' => trans('project.not_found')]);
        }
        $this->projectRepository->delete($id);
        return response()->json(['status' => STATUS_SUCCESS, 'id' => $id, 'message' => trans('project.delete_success')]);
    }
}
