<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchWeatherRequest;
use App\Services\OpenWeatherMapService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class OpenWeatherMapController
 * @package App\Http\Controllers\Api
 */
class OpenWeatherMapController extends Controller
{
    /**
     * @var OpenWeatherMapService
     */
    private $openWeatherMapService;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * OpenWeatherMapController constructor.
     * @param OpenWeatherMapService $openWeatherMapService
     */
    public function __construct(
        OpenWeatherMapService $openWeatherMapService,
        ResponseFactory $responseFactory
    ) {
        $this->openWeatherMapService = $openWeatherMapService;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(SearchWeatherRequest $request): JsonResponse
    {
        $result = $this->openWeatherMapService->getJson($request->params);

        return $this
            ->responseFactory
            ->json($result,Response::HTTP_OK);
    }
}
