<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\LeagueService;
use AppBundle\Services\TeamService;
use AppBundle\Entity\League;
use AppBundle\Validation\LeagueValidator;
use AppBundle\Validation\TeamValidator;

class LeagueController extends Controller
{
    /**
     * @var LeagueService
     */
    private $service;

    /**
     * @var TeamService
     */
    private $teamService;

    /**
     * @param LeagueService $leagueService
     * @param TeamService $teamService
     */
    public function __construct(LeagueService $leagueService, TeamService $teamService)
    {
        $this->service = $leagueService;
        $this->teamService = $teamService;
    }

    /**
     * Create a league
     *
     * @Route("/league/", methods={"POST"})
     * @param Request $request
     * @param LeagueValidator $validator
     *
     * @return JsonResponse
     */
    public function createAction(Request $request, LeagueValidator $validator) : JsonResponse
    {
        try {
            $request = $validator->isValid($request);

            /** @var League $league */
            $league = $this->service->create($request['name']);

            return new JsonResponse(
                $league->toArray(),
                200
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        }
    }

    /**
     * Delete a league
     *
     * @Route("/league/{id}", methods={"DELETE"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request) : JsonResponse
    {
        $leagueId = (int) $request->get("id");

        try {
            $this->service->delete($leagueId);

            return new JsonResponse(
                [],
                204
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        }
    }

    /**
     * Delete a league
     *
     * @Route("/league/{id}", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAction(Request $request) : JsonResponse
    {
        $leagueId = $request->get("id");

        try {
            /** @var League $league */
            $league = $this->service->get($leagueId);

            return new JsonResponse(
                $league ? $league->toArray() : null,
                200
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        }
    }

    /**
     * Create a team
     *
     * @Route("league/{id}/team", methods={"POST"})
     * @param Request $request
     * @param TeamValidator $validator
     *
     * @return JsonResponse
     */
    public function createTeamAction(Request $request, TeamValidator $validator) : JsonResponse
    {
        $leagueId = $request->get("id");

        $request = $validator->isValid($request);

        $name = $request["name"];
        $stripe = $request["stripe"];

        try {
            /** @var Team team */
            $team = $this->teamService->create($name, $stripe, $leagueId);

            return new JsonResponse(
                $team->toArray(),
                200
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                500
            );
        }
    }
}
