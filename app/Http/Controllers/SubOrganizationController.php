<?php

namespace App\Http\Controllers;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SubOrganizationResource::collection($this->subOrganizationRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return SubOrganizationResource
     */
    public function store(Request $request)
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
    public function show(SubOrganization $subOrganization)
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
    public function update(Request $request, SubOrganization $subOrganization)
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
    public function destroy(SubOrganization $subOrganization)
    {
        if ($this->subOrganizationRepository->deleteByModel($subOrganization)) return response('', 200);

        abort(500);
    }
}
