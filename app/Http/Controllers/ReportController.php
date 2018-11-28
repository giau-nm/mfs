<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Repositories\ReportRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\ProjectRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Project;
use App\Models\Device;
use App\Models\Report;

class ReportController extends AppBaseController
{
    /** @var  ReportRepository */
    private $reportRepository;
    private $deviceRepository;
    private $projectRepository;


    public function __construct(ReportRepository $reportRepo, DeviceRepository $deviceRepo, ProjectRepository $projectRepo)
    {
        $this->reportRepository = $reportRepo;
        $this->deviceRepository = $deviceRepo;
        $this->projectRepository = $projectRepo;
    }

    /**
     * Display a listing of the Report.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $reports = $this->reportRepository->queryAndPaginate($request);
        $sortLinks = $this->reportRepository->generateSortUrl($request);

        return view('reports.index')
            ->with('reports', $reports)
            ->with('listStatus', $this->reportRepository->listReportStatus())
            ->with('request', $request->all())
            ->with('sortLinks', $sortLinks)
            ->with('pageTitle', trans('label.report.title.index'));
    }

    /**
     * Show the form for creating a new Report.
     *
     * @return Response
     */
    public function create()
    {
        return view('reports.create', [
            'projects' => $this->projectRepository->pluck('name', 'id'),
            'devices' => $this->deviceRepository->pluck('name', 'id'),
            'pageTitle' => trans('report.title.create'),
        ]);
    }

    /**
     * Store a newly created Report in storage.
     *
     * @param CreateReportRequest $request
     *
     * @return Response
     */
    public function store(CreateReportRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::user()->id;
        $input['status'] = Report::STATUS_CREATED;
        $checkForm = $this->reportRepository->validateCreateReport($input);

        if (isset($checkForm['status']) && $checkForm['status'] == STATUS_ERROR) {
            return redirect(route('reports.create'))
                ->with('errors', $checkForm['errors'])
                ->withInput($input);
        }
        $report = $this->reportRepository->create($input);

        Flash::success(trans('report.save_success'));

        return redirect(route('reports.index'));
    }

    /**
     * Display the specified Report.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pageTitle = trans('report.title.show');
        $report = $this->reportRepository->findWithoutFail($id);

        if (empty($report) || $report->user_id != \Auth::user()->id) {
            Flash::error(trans('report.not_found'));

            return redirect(route('reports.index'));
        }

        return view('reports.show', compact('pageTitle'))->with('report', $report);
    }

    /**
     * Remove the specified Report from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $report = $this->reportRepository->findWithoutFail($id);

        if (empty($report) || $report->user_id != \Auth::user()->id) {
            Flash::error(trans('report.not_found'));
            return redirect(route('reports.index'));
        }

        if ((!$request->user->isAdmin() && $report->status == STATUS_REPORT_NEW) || $request->user->isAdmin()) {
            $this->reportRepository->delete($id);
            Flash::success(trans('report.delete_success'));
            return redirect(route('reports.index'));
        } else {
            Flash::error(trans('report.delete_permission_deny'));
            return redirect(route('reports.index'));
        }
    }


}
