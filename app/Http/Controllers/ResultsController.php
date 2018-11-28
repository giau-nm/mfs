<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResultsRequest;
use App\Http\Requests\UpdateResultsRequest;
use App\Repositories\ResultsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ResultsController extends AppBaseController
{
    /** @var  ResultsRepository */
    private $resultsRepository;

    public function __construct(ResultsRepository $resultsRepo)
    {
        $this->resultsRepository = $resultsRepo;
    }

    /**
     * Display a listing of the Results.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->resultsRepository->pushCriteria(new RequestCriteria($request));
        $results = $this->resultsRepository->all();

        return view('results.index')
            ->with('results', $results);
    }

    /**
     * Show the form for creating a new Results.
     *
     * @return Response
     */
    public function create()
    {
        return view('results.create');
    }

    /**
     * Store a newly created Results in storage.
     *
     * @param CreateResultsRequest $request
     *
     * @return Response
     */
    public function store(CreateResultsRequest $request)
    {
        $input = $request->all();

        $results = $this->resultsRepository->create($input);

        Flash::success('Results saved successfully.');

        return redirect(route('results.index'));
    }

    /**
     * Display the specified Results.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $results = $this->resultsRepository->findWithoutFail($id);

        if (empty($results)) {
            Flash::error('Results not found');

            return redirect(route('results.index'));
        }

        return view('results.show')->with('results', $results);
    }

    /**
     * Show the form for editing the specified Results.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $results = $this->resultsRepository->findWithoutFail($id);

        if (empty($results)) {
            Flash::error('Results not found');

            return redirect(route('results.index'));
        }

        return view('results.edit')->with('results', $results);
    }

    /**
     * Update the specified Results in storage.
     *
     * @param  int              $id
     * @param UpdateResultsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResultsRequest $request)
    {
        $results = $this->resultsRepository->findWithoutFail($id);

        if (empty($results)) {
            Flash::error('Results not found');

            return redirect(route('results.index'));
        }

        $results = $this->resultsRepository->update($request->all(), $id);

        Flash::success('Results updated successfully.');

        return redirect(route('results.index'));
    }

    /**
     * Remove the specified Results from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $results = $this->resultsRepository->findWithoutFail($id);

        if (empty($results)) {
            Flash::error('Results not found');

            return redirect(route('results.index'));
        }

        $this->resultsRepository->delete($id);

        Flash::success('Results deleted successfully.');

        return redirect(route('results.index'));
    }
}
