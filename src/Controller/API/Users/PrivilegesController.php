<?php
declare(strict_types=1);

namespace App\Controller\API\Users;


use App\Users\Model\Privileges;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PrivilegesController extends AbstractController
{

    /**
     * @Route("/privileges", methods={"GET"})
     * @return JsonResponse
     */
    public function default(): JsonResponse
    {
        return $this->json(Privileges::privilegesList());
    }

}