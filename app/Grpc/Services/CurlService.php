<?php

namespace App\Grpc\Services;

use App\SyncInvoke\Helpers\SyncInvokeHelper;
use Mix\Context\Context;
use Mix\SyncInvoke\Pool\ConnectionPool;
use Php\Micro\Srv\Curl\CurlInterface;
use Php\Micro\Srv\Curl\Request;
use Php\Micro\Srv\Curl\Response;

/**
 * Class CurlService
 * @package App\Grpc\Services
 */
class CurlService implements CurlInterface
{

    /**
     * @var ConnectionPool
     */
    public $pool;

    /**
     * CurlService constructor.
     */
    public function __construct()
    {
        $this->pool = context()->get(ConnectionPool::class);
    }

    /**
     * Get
     * @param Context $context
     * @param Request $request
     * @return Response
     * @throws \Mix\SyncInvoke\Exception\InvokeException
     * @throws \Swoole\Exception
     */
    public function Get(Context $context, Request $request): Response
    {
        // 跨进程执行同步代码
        $response = new Response();
        $data     = SyncInvokeHelper::invoke($this->pool, function () use ($request, $response) {
            /**
             * 闭包内部的同步阻塞代码会在同步服务器进程中执行
             * 代码异常会抛出 InvokeException，即便指定 throw new FooException() 也会转换为 InvokeException
             * 闭包内部代码包含的 Class 文件修改后，需重启 mix-syncinvoke 服务器进程
             */

            /**
             * 直接传输代码的方式
             * 该方式传输数据多，但修改代码无需重启 mix-syncinvoke 服务器进程
             */
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL            => $request->getUrl(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "GET",
            ]);
            $result = curl_exec($curl);
            $error  = curl_error($curl);
            curl_close($curl);
            if ($error) {
                $response->setError($error);
                return $response;
            }
            $response->setResult($result);
            return $response;
        });
        return $response;
    }

}
