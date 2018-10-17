<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubOrganization\CreateSubOrganizationRequest;
use App\Http\Requests\SubOrganization\DeleteSubOrganizationRequest;
use App\Http\Requests\SubOrganization\ShowSubOrganizationRequest;
use App\Http\Requests\SubOrganization\UpdateSubOrganizationRequest;
use App\Http\Requests\SubOrganization\ViewSubOrganizationRequest;
use App\Http\Resources\SubOrganizationResource;
use App\Repositories\SubOrganizationRepository;
use App\SubOrganization;
use Illuminate\Http\Request;

class SubOrganizationController extends Controller
{
    protected $subOrganizationRepository;

    public function __construct(SubOrganizationRepository $subOrganizationRepository)
    {
        $this->subOrganizationRepository = $subOrganizationRepository;

        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ViewSubOrganizationRequest $request)
    {
        return SubOrganizationResource::collection($this->subOrganizationRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return SubOrganizationResource
     */
    public function store(CreateSubOrganizationRequest $request)
    {
        return new SubOrganizationResource($this->subOrganizationRepository->create($request->only([
            'name',
            'founded_at',
            'description',
            'country_id',
            'organization_id'
        ])));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubOrganization $subOrganization
     * @return SubOrganizationResource
     */
    public function show(SubOrganization $subOrganization, ShowSubOrganizationRequest $request)
    {
        return new SubOrganizationResource($subOrganization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SubOrganization $subOrganization
     * @return SubOrganizationResource
     */
    public function update(UpdateSubOrganizationRequest $request, SubOrganization $subOrganization)
    {
        return new SubOrganizationResource($this->subOrganizationRepository->updateByModel($subOrganization, $request->only([
            'name',
            'founded_at',
            'description',
            'country_id',
            'organization_id'
        ])));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubOrganization $subOrganization
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(SubOrganization $subOrganization, DeleteSubOrganizationRequest $request)
    {
        if ($this->subOrganizationRepository->deleteByModel($subOrganization)) return response('', 200);

        abort(500);
    }
}
