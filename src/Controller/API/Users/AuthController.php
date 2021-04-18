<?php
declare(strict_types=1);

namespace App\Controller\API\Users;


use App\Users\Service\AuthServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller\API\Users
 */
class AuthController extends AbstractController
{

    /**
     * @var AuthServiceInterface
     */
    private $authService;

    /**
     * AuthController constructor.
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @Route("/login")
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $token = $this->authService->login($data['email'], $data['password']);

        return $this->json([
            'access_token' => $token
        ]);

    }

}