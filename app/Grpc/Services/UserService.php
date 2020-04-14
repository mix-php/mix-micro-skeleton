<?php

namespace App\Grpc\Services;

use App\Grpc\Models\UserModel;
use Mix\Context\Context;
use Php\Micro\Srv\User\Request;
use Php\Micro\Srv\User\Response;
use Php\Micro\Srv\User\UserInterface;

/**
 * Class UserService
 * @package App\Grpc\Services
 */
class UserService implements UserInterface
{

    /**
     * Add
     * @param Context $context
     * @param Request $request
     * @return Response
     */
    public function Add(Context $context, Request $request): Response
    {
        $model    = new UserModel();
        $result   = $model->add($request);
        $response = new Response();
        if ($result) {
            $response->setStatus('success');
        } else {
            $response->setStatus('fail');
        }
        return $response;
    }

}
