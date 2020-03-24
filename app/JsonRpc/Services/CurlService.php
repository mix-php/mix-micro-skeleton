<?php

namespace App\JsonRpc\Services;

use App\SyncInvoke\Helpers\SyncInvokeHelper;
use Mix\SyncInvoke\Pool\ConnectionPool;

/**
 * Class CurlService
 * @package App\JsonRpc\Services
 */
class CurlService
{

    /**
     * @var ConnectionPool
     */
    public $pool;

    /**
     * CurlController constructor.
     */
    public function __construct()
    {
        $this->pool = context()->get(ConnectionPool::class);
    }

    /**
     * Get
     * @param string $url
     * @return string
     * @throws \Mix\SyncInvoke\Exception\InvokeException
     * @throws \Swoole\Exception
     */
    public function Get(string $url): string
    {
        // 跨进程执行同步代码
        $data = SyncInvokeHelper::invoke($this->pool, function () use ($url) {
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
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "GET",
            ]);
            $response = curl_exec($curl);
            $err      = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return "cURL Error #: " . $err;
            }
            return $response;
        });
        return $data;
    }

}
