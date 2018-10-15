<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\Country\CreateCountryRequest;
use App\Http\Requests\Country\DeleteCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->middleware('auth:api')->except(['index', 'show']);

        $this->countryRepository = $countryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CountryResource::collection($this->countryRepository->getAll(20, true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCountryRequest $request
     * @return CountryResource
     */
    public function store(CreateCountryRequest $request)
    {
        return new CountryResource($this->countryRepository->create($request->only([
            'name',
            'code'
        ])));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country $country
     * @return CountryResource
     */
    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCountryRequest $request
     * @param  \App\Country $country
     * @return CountryResource
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        return new CountryResource($this->countryRepository->updateByModel($country, $request->only([
            'name',
            'code'
        ])));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCountryRequest $request
     * @param  \App\Country $country
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(DeleteCountryRequest $request, Country $country)
    {
        if ($this->countryRepository->deleteByModel($country)) return response('', 200);

        abort(500);
    }
}
