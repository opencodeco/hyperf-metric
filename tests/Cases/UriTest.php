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
namespace HyperfTest\Metric\Cases;

use Hyperf\Metric\Support\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class UriTest extends TestCase
{
    public function testSanitizeNumbers(): void
    {
        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v2/test/<NUMBER>', Uri::sanitize('/v2/test/123'));
        self::assertSame('/v3/test/<NUMBER>/bar', Uri::sanitize('/v3/test/123/bar'));
        self::assertSame('/v4/test/<NUMBER>/bar/<NUMBER>/', Uri::sanitize('/v4/test/123/bar/456/'));
        self::assertSame('/v5/test/<NUMBER>/<NUMBER>', Uri::sanitize('/v5/test/123/456'));
        self::assertSame('/v6/test/<NUMBER>/<NUMBER>/', Uri::sanitize('/v6/test/123/456/'));
        self::assertSame('/v7/test/<NUMBER>/<NUMBER>/<NUMBER>', Uri::sanitize('/v7/test/123/456/789'));
        self::assertSame('/v8/test/<NUMBER>/<NUMBER>/<NUMBER>/', Uri::sanitize('/v8/test/123/456/789/'));
    }

    public function testSanitizeLicensePlatesStrings(): void
    {
        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v2/test/<LICENSE-PLATE>', Uri::sanitize('/v2/test/PET9D49'));
        self::assertSame('/v2/test/<LICENSE-PLATE>', Uri::sanitize('/v2/test/PET9349'));
        self::assertSame('/v3/test/<LICENSE-PLATE>/bar', Uri::sanitize('/v3/test/PET9D49/bar'));
        self::assertSame('/v3/test/<LICENSE-PLATE>/bar', Uri::sanitize('/v3/test/PET9349/bar'));
        self::assertSame('/v4/test/<LICENSE-PLATE>/bar/<LICENSE-PLATE>/', Uri::sanitize('/v4/test/PET9D49/bar/PET9D49/'));
        self::assertSame('/v4/test/<LICENSE-PLATE>/bar/<LICENSE-PLATE>/', Uri::sanitize('/v4/test/PET9349/bar/PET9349/'));
        self::assertSame('/v5/test/<LICENSE-PLATE>/<LICENSE-PLATE>', Uri::sanitize('/v5/test/PET9D49/PET9D49'));
        self::assertSame('/v5/test/<LICENSE-PLATE>/<LICENSE-PLATE>', Uri::sanitize('/v5/test/PET9349/PET9349'));
        self::assertSame('/v6/test/<LICENSE-PLATE>/<LICENSE-PLATE>/', Uri::sanitize('/v6/test/PET9D49/PET9D49/'));
        self::assertSame('/v6/test/<LICENSE-PLATE>/<LICENSE-PLATE>/', Uri::sanitize('/v6/test/PET9349/PET9349/'));
        self::assertSame('/v7/test/<LICENSE-PLATE>/<LICENSE-PLATE>/<LICENSE-PLATE>', Uri::sanitize('/v7/test/PET9D49/PET9D49/PET9D49'));
        self::assertSame('/v7/test/<LICENSE-PLATE>/<LICENSE-PLATE>/<LICENSE-PLATE>', Uri::sanitize('/v7/test/PET9349/PET9349/PET9349'));
        self::assertSame('/v8/test/<LICENSE-PLATE>/<LICENSE-PLATE>/<LICENSE-PLATE>/', Uri::sanitize('/v8/test/PET9D49/PET9D49/PET9D49/'));
        self::assertSame('/v8/test/<LICENSE-PLATE>/<LICENSE-PLATE>/<LICENSE-PLATE>/', Uri::sanitize('/v8/test/PET9349/PET9349/PET9349/'));
    }

    public function testClearUriUuids(): void
    {
        $uuid = '123e4567-e89b-12d3-a456-426614174000';

        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v2/test/<UUID>', Uri::sanitize("/v2/test/{$uuid}"));
        self::assertSame('/v3/test/<UUID>/bar', Uri::sanitize("/v3/test/{$uuid}/bar"));
        self::assertSame('/v4/test/<UUID>/bar/<UUID>/', Uri::sanitize("/v4/test/{$uuid}/bar/{$uuid}/"));
        self::assertSame('/v5/test/<UUID>/<UUID>', Uri::sanitize("/v5/test/{$uuid}/{$uuid}"));
        self::assertSame('/v6/test/<UUID>/<UUID>/', Uri::sanitize("/v6/test/{$uuid}/{$uuid}/"));
        self::assertSame('/v7/test/<UUID>/<UUID>/<UUID>', Uri::sanitize("/v7/test/{$uuid}/{$uuid}/{$uuid}"));
        self::assertSame('/v8/test/<UUID>/<UUID>/<UUID>/', Uri::sanitize("/v8/test/{$uuid}/{$uuid}/{$uuid}/"));
    }

    public function testClearUriOids(): void
    {
        $oid = '650229807612bba4984d1fc7';
        $oidShort = '65022612bba84d1f';

        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v2/test/<OID>', Uri::sanitize("/v2/test/{$oid}"));
        self::assertSame('/v3/test/<OID>/bar', Uri::sanitize("/v3/test/{$oid}/bar"));
        self::assertSame('/v4/test/<OID>/bar/<OID>/', Uri::sanitize("/v4/test/{$oid}/bar/{$oid}/"));
        self::assertSame('/v5/test/<OID>/<OID>', Uri::sanitize("/v5/test/{$oid}/{$oid}"));
        self::assertSame('/v6/test/<OID>/<OID>/', Uri::sanitize("/v6/test/{$oid}/{$oid}/"));
        self::assertSame('/v7/test/<OID>/<OID>/<OID>', Uri::sanitize("/v7/test/{$oid}/{$oid}/{$oid}"));
        self::assertSame('/v8/test/<OID>/<OID>/<OID>/', Uri::sanitize("/v8/test/{$oid}/{$oid}/{$oid}/"));
        self::assertSame('/v9/test/<OID>/bar/<NUMBER>', Uri::sanitize("/v9/test/{$oidShort}/bar/12345"));
    }

    public function testAddsInitialSlash(): void
    {
        self::assertSame('/v1/', Uri::sanitize('/v1/'));
        self::assertSame('/v1', Uri::sanitize('v1'));
        self::assertSame('/v1/', Uri::sanitize('v1/'));
        self::assertSame('/v1/test/', Uri::sanitize('/v1/test/'));
        self::assertSame('/v1/test', Uri::sanitize('v1/test'));
        self::assertSame('/v1/test/', Uri::sanitize('v1/test/'));
    }

    public function testAndroidId(): void
    {
        $this->markTestSkipped();

        self::assertSame('/device/<ANDROID-ID>/user/<NUMBER>', Uri::sanitize('/devices/a436d9ffefef80e8/user/999'));
        self::assertSame('/device/<ANDROID-ID>/user/<NUMBER>', Uri::sanitize('/devices/7b5d68f217d90ff5/user/999'));
        self::assertSame('/device/<ANDROID-ID>/user/<NUMBER>', Uri::sanitize('/devices/dc900fb903cc308c/user/999'));
        self::assertSame('/device/<ANDROID-ID>/user/<NUMBER>', Uri::sanitize('/devices/86d144c9078c8176/user/999'));
        self::assertSame('/device/<ANDROID-ID>/user/<NUMBER>', Uri::sanitize('/devices/86d144c9078c8176/user/8045169'));
    }

    public function testSanitizeHashsStrings(): void
    {
        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v2/test/<SHA1>', Uri::sanitize('/v2/test/141da78905dcaa7ed8d4da7c3f49a2415ebdc110'));
        self::assertSame('/v2/test/<SHA1>', Uri::sanitize('/v2/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220'));
        self::assertSame('/v3/test/<SHA1>/bar', Uri::sanitize('/v3/test/81FE8BFE87576C3ECB22426F8E57847382917ACF/bar'));
        self::assertSame('/v3/test/<SHA1>/bar', Uri::sanitize('/v3/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/bar'));
        self::assertSame('/v4/test/<SHA1>/bar/<SHA1>/', Uri::sanitize('/v4/test/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/bar/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/'));
        self::assertSame('/v4/test/<SHA1>/bar/<SHA1>/', Uri::sanitize('/v4/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/bar/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/'));
        self::assertSame('/v5/test/<SHA1>/<SHA1>', Uri::sanitize('/v5/test/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/141da78905dcaa7ed8d4da7c3f49a2415ebdc110'));
        self::assertSame('/v5/test/<SHA1>/<SHA1>', Uri::sanitize('/v5/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220'));
        self::assertSame('/v6/test/<SHA1>/<SHA1>/', Uri::sanitize('/v6/test/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/'));
        self::assertSame('/v6/test/<SHA1>/<SHA1>/', Uri::sanitize('/v6/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/'));
        self::assertSame('/v7/test/<SHA1>/<SHA1>/<SHA1>', Uri::sanitize('/v7/test/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/141da78905dcaa7ed8d4da7c3f49a2415ebdc110'));
        self::assertSame('/v7/test/<SHA1>/<SHA1>/<SHA1>', Uri::sanitize('/v7/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220'));
        self::assertSame('/v8/test/<SHA1>/<SHA1>/<SHA1>/', Uri::sanitize('/v8/test/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/141da78905dcaa7ed8d4da7c3f49a2415ebdc110/'));
        self::assertSame('/v8/test/<SHA1>/<SHA1>/<SHA1>/', Uri::sanitize('/v8/test/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/7110EDA4D09E062AA5E4A390B0A572AC0D2C0220/'));
    }

    public function testSanitizeEndToEndId(): void
    {
        $e2eid = 'E99999999202401010000abcDEF12345';

        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v2/test/<E2E-ID>', Uri::sanitize("/v2/test/{$e2eid}"));
        self::assertSame('/v3/test/<E2E-ID>/bar', Uri::sanitize("/v3/test/{$e2eid}/bar"));
        self::assertSame('/v4/test/<E2E-ID>/bar/<E2E-ID>/', Uri::sanitize("/v4/test/{$e2eid}/bar/{$e2eid}/"));
        self::assertSame('/v5/test/<E2E-ID>/<E2E-ID>', Uri::sanitize("/v5/test/{$e2eid}/{$e2eid}"));
        self::assertSame('/v6/test/<E2E-ID>/<E2E-ID>/', Uri::sanitize("/v6/test/{$e2eid}/{$e2eid}/"));
        self::assertSame('/v7/test/<E2E-ID>/<E2E-ID>/<E2E-ID>', Uri::sanitize("/v7/test/{$e2eid}/{$e2eid}/{$e2eid}"));
        self::assertSame('/v8/test/<E2E-ID>/<E2E-ID>/<E2E-ID>/', Uri::sanitize("/v8/test/{$e2eid}/{$e2eid}/{$e2eid}/"));
    }

    public function testWithMaskParams(): void
    {
        $uriMask = [
            '/\/[a-f0-9]{64}/i' => '/<SHA256-ID>',
        ];

        self::assertSame('/v1/test', Uri::sanitize('/v1/test', $uriMask));
        self::assertSame('/v2/test/<SHA256-ID>', Uri::sanitize('/v2/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7', $uriMask));
        self::assertSame('/v3/test/<SHA256-ID>/bar', Uri::sanitize('/v3/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/bar', $uriMask));
        self::assertSame('/v4/test/<SHA256-ID>/bar/<SHA256-ID>/', Uri::sanitize('/v4/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/bar/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/', $uriMask));
        self::assertSame('/v5/test/<SHA256-ID>/<SHA256-ID>', Uri::sanitize('/v5/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7', $uriMask));
        self::assertSame('/v6/test/<SHA256-ID>/<SHA256-ID>/', Uri::sanitize('/v6/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/', $uriMask));
        self::assertSame('/v7/test/<SHA256-ID>/<SHA256-ID>/<SHA256-ID>', Uri::sanitize('/v7/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7', $uriMask));
        self::assertSame('/v8/test/<SHA256-ID>/<SHA256-ID>/<SHA256-ID>/', Uri::sanitize('/v8/test/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/54cf575c04fdef4667094b6fc4fab8014dd3fa53576b644ec399452c43b5e7f7/', $uriMask));
    }

    public function testClearUriExternalIds(): void
    {
        self::assertSame('/v1/test', Uri::sanitize('/v1/test'));
        self::assertSame('/v1/test/<EXTERNAL-ID>', Uri::sanitize('/v1/test/RR2101818220123720H9KJTERfw1a'));
        self::assertSame('/v3/test/<EXTERNAL-ID>/bar', Uri::sanitize('/v3/test/RN2401818220250720G4KJTQyU6Ds/bar'));
        self::assertSame('/v4/test/<EXTERNAL-ID>/bar/<EXTERNAL-ID>/', Uri::sanitize('/v4/test/RR2101818220123720H9KJTERfw1a/bar/RN2401818220250720G4KJTQyU6Ds/'));
        self::assertSame('/v5/test/<EXTERNAL-ID>/<EXTERNAL-ID>', Uri::sanitize('/v5/test/RR2101818220123720H9KJTERfw1a/RN2401818220250720G4KJTQyU6Ds'));
        self::assertSame('/v7/test/<EXTERNAL-ID>/<EXTERNAL-ID>/<EXTERNAL-ID>/', Uri::sanitize('/v7/test/RR2101818220123720H9KJTERfw1a/RN2001818220123720H9KJTERBd52/RR2123818220123730H9KJTERBd52/'));
        self::assertSame('/v9/test/<EXTERNAL-ID>/bar/<NUMBER>', Uri::sanitize('/v9/test/RR2101818220123720H9KJTERfw1a/bar/12345'));
    }
}
