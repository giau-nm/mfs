<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRatingLevelsRequest;
use App\Http\Requests\UpdateRatingLevelsRequest;
use App\Repositories\RatingLevelsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RatingLevelsController extends AppBaseController
{
    /** @var  RatingLevelsRepository */
    private $ratingLevelsRepository;

    public function __construct(RatingLevelsRepository $ratingLevelsRepo)
    {
        $this->ratingLevelsRepository = $ratingLevelsRepo;
    }

    /**
     * Display a listing of the RatingLevels.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->ratingLevelsRepository->pushCriteria(new RequestCriteria($request));
        $ratingLevels = $this->ratingLevelsRepository->all();

        return view('rating_levels.index')
            ->with('ratingLevels', $ratingLevels);
    }

    /**
     * Show the form for creating a new RatingLevels.
     *
     * @return Response
     */
    public function create()
    {
        return view('rating_levels.create');
    }

    /**
     * Store a newly created RatingLevels in storage.
     *
     * @param CreateRatingLevelsRequest $request
     *
     * @return Response
     */
    public function store(CreateRatingLevelsRequest $request)
    {
        $input = $request->all();

        $ratingLevels = $this->ratingLevelsRepository->create($input);

        Flash::success('Rating Levels saved successfully.');

        return redirect(route('ratingLevels.index'));
    }

    /**
     * Display the specified RatingLevels.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ratingLevels = $this->ratingLevelsRepository->findWithoutFail($id);

        if (empty($ratingLevels)) {
            Flash::error('Rating Levels not found');

            return redirect(route('ratingLevels.index'));
        }

        return view('rating_levels.show')->with('ratingLevels', $ratingLevels);
    }

    /**
     * Show the form for editing the specified RatingLevels.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ratingLevels = $this->ratingLevelsRepository->findWithoutFail($id);

        if (empty($ratingLevels)) {
            Flash::error('Rating Levels not found');

            return redirect(route('ratingLevels.index'));
        }

        return view('rating_levels.edit')->with('ratingLevels', $ratingLevels);
    }

    /**
     * Update the specified RatingLevels in storage.
     *
     * @param  int              $id
     * @param UpdateRatingLevelsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRatingLevelsRequest $request)
    {
        $ratingLevels = $this->ratingLevelsRepository->findWithoutFail($id);

        if (empty($ratingLevels)) {
            Flash::error('Rating Levels not found');

            return redirect(route('ratingLevels.index'));
        }

        $ratingLevels = $this->ratingLevelsRepository->update($request->all(), $id);

        Flash::success('Rating Levels updated successfully.');

        return redirect(route('ratingLevels.index'));
    }

    /**
     * Remove the specified RatingLevels from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ratingLevels = $this->ratingLevelsRepository->findWithoutFail($id);

        if (empty($ratingLevels)) {
            Flash::error('Rating Levels not found');

            return redirect(route('ratingLevels.index'));
        }

        $this->ratingLevelsRepository->delete($id);

        Flash::success('Rating Levels deleted successfully.');

        return redirect(route('ratingLevels.index'));
    }
}
