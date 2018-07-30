<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LogController
 */
class LogController extends Controller
{
    /**
     * @param LogRepository $logRepository
     * @return Response
     */
    public function list(LogRepository $logRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        $logs = $logRepository->findAll();

        return $this->render(
            'Log/list.html.twig',
            [
                'logs' => $logs
            ]
        );
    }

    /**
     * @param int $id
     * @param LogRepository $logRepository
     * @return Response
     */
    public function show(int $id, LogRepository $logRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        $log = $logRepository->find($id);

        return $this->render(
            'Log/show.html.twig',
            [
                'log' => $log
            ]
        );
    }
}
