<?php
declare(strict_types=1);

namespace App\Controller\API\Users;

use App\Users\DataTransfer\UserDataTransfer;
use App\Users\Service\UsersServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    private $usersService;

    public function __construct(UsersServiceInterface $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * @Route("/list", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $order = $request->query->get('order') ?? 'DESC';
        $limit = $request->query->get('limit') ?? 10;
        $offset = $request->query->get('offset') ?? 0;

        $users = $this->usersService->list(['id' => $order], (int)$limit, (int)$offset);

        return $this->json($users);
    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @return JsonResponse
     */
    public function one(int $id): JsonResponse
    {
        $users = $this->usersService->one($id);

        return $this->json($users);
    }

    /**
     * @Route("/signup", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function signup(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->usersService->signup(
            $data['email'],
            $data['password']
        );


        return $this->json($user);
    }

    /**
     * @Route("/create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->usersService->create(
            $data['email'],
            $data['password'],
            $data['privileges']
        );

        return $this->json($user);
    }


    /**
     * @Route("/{id}", methods={"PUT"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function edit(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $dto = new UserDataTransfer($data);

        $user = $this->usersService->edit($id, $dto);

        return $this->json($user);
    }
}