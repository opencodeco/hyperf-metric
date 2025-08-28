<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf + OpenCodeCo
 *
 * @link     https://opencodeco.dev
 * @document https://hyperf.wiki
 * @contact  leo@opencodeco.dev
 * @license  https://github.com/opencodeco/hyperf-metric/blob/main/LICENSE
 */

namespace Hyperf\Metric\Middleware;

use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\Metric\Metric;
use Hyperf\Metric\Support\Uri;
use Hyperf\Metric\Timer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class MetricMiddleware implements MiddlewareInterface
{
    protected array $config;

    public function __construct(
        ConfigInterface $config,
    ) {
        $this->config = $config->get('metric');
    }

    /**
     * Process an incoming server request.
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (! empty($this->config['ignore_path']) && preg_match($this->config['ignore_path'], $request->getUri()->getPath())) {
            return $handler->handle($request);
        }

        $labels = [
            'request_status' => '500',
            'request_path' => $this->getPath($request),
            'request_method' => $request->getMethod(),
        ];

        $timer = new Timer('http_requests', $labels);

        try {
            $response = $handler->handle($request);
            $labels['request_status'] = (string) $response->getStatusCode();
            $timer->end($labels);

            return $response;
        } catch (HttpException $httpException) {

            // HttpExceptions are valid HTTP responses, not internal errors
            $labels['request_status'] = (string) $httpException->getStatusCode();
            $timer->end($labels);

            throw $httpException;
        } catch (Throwable $exception) {
            $this->countException($request, $exception);
            $timer->end($labels);

            throw $exception;
        }
    }

    protected function getPath(ServerRequestInterface $request): string
    {
        $dispatched = $request->getAttribute(Dispatched::class);
        if (! $dispatched) {
            return Uri::sanitize($request->getUri()->getPath());
        }
        if (! $dispatched->handler) {
            return 'not_found';
        }
        return $dispatched->handler->route;
    }

    protected function countException(ServerRequestInterface $request, Throwable $exception): void
    {
        $labels = [
            'request_path' => $this->getPath($request),
            'request_method' => $request->getMethod(),
            'class' => $exception::class,
        ];

        Metric::count('exception_count', 1, $labels);
    }
}
