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

namespace Hyperf\Metric\Support;

final class Uri
{
    public static function sanitize(string $uri, array $uriMask = []): string
    {
        return preg_replace(
            array_merge(
                array_keys($uriMask),
                [
                    '/\/(?<=\/)[ED]\d{8}\d{12}[0-9a-zA-Z]{11}(?=\/)?/',
                    '/\/(?<=\/)[a-f0-9]{40}(?=\/)?/i',
                    '/\/(?<=\/)([A-F0-9]{8}-[A-F0-9]{4}-[A-F0-9]{4}-[A-F0-9]{4}-[A-F0-9]{12})(?=\/)?/i',
                    '/\/(?<=\/)([A-Z]{3}-?\d[0-9A-Z]\d{2})(?=\/)?/i',
                    '/\/(?<=\/)[0-9A-F]{16,24}(?=\/)?/i',
                    '/\/(?<=\/)\d+(?=\/)?/',
                ],
            ),
            array_merge(
                array_values($uriMask),
                [
                    '/<E2E-ID>',
                    '/<SHA1>',
                    '/<UUID>',
                    '/<LICENSE-PLATE>',
                    '/<OID>',
                    '/<NUMBER>',
                ],
            ),
            '/' . ltrim($uri, '/'),
        );
    }
}