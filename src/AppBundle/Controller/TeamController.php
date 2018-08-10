<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\TeamService;
use AppBundle\Entity\Team;
use AppBundle\Validation\TeamValidator;

class TeamController extends Controller
{
    /**
     * @var TeamService
     */
    private $service;

    /**
     * @param TeamService $teamService
     */
    public function __construct(TeamService $teamService)
    {
        $this->service = $teamService;
    }

    /**
     * Delete a team
     *
     * @Route("/team/{id}", methods={"DELETE"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request) : JsonResponse
    {
        $teamId = (int) $request->get("id");

        try {
            $this->service->delete($teamId);

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
     * Delete a team
     *
     * @Route("/team/{id}", methods={"GET"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAction(Request $request) : JsonResponse
    {
        $teamId = $request->get("id");

        try {
            /** @var Team team */
            $team = $this->service->get($teamId);

            return new JsonResponse(
                $team ? $team->toArray() : null,
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
     * Update a team
     *
     * @Route("/team/{id}", methods={"PUT"})
     * @param Request $request
     * @param TeamValidator $validator
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request, TeamValidator $validator) : JsonResponse
    {
        $teamId = $request->get("id");

        $request = $validator->isValid($request);

        $name = $request["name"];
        $stripe = $request["stripe"];
        $league = $request["league"];

        try {
            /** @var Team team */
            $team = $this->service->update($teamId, $name, $stripe, $league);

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
