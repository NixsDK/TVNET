<?php
declare(strict_types=1);

namespace app;

use Carbon\Carbon;

class Cache
{
    public static function has(string $key): bool
    {
        $cacheFile = self::getCacheFilePath($key);

        if (!file_exists($cacheFile)) {
            return false;
        }

        $content = self::readCacheFile($cacheFile);
        return Carbon::parse($content['expires_at'])->gt(Carbon::now());
    }

    public static function save(string $key, string $content, int $ttl = 120): void
    {
        $cacheFile = self::getCacheFilePath($key);
        $expiresAt = Carbon::now()->addSeconds($ttl);

        self::writeCacheFile($cacheFile, [
            'expires_at' => $expiresAt,
            'content' => $content
        ]);
    }

    public static function get(string $key): ?string
    {
        $cacheFile = self::getCacheFilePath($key);

        if (!file_exists($cacheFile)) {
            return null;
        }

        $content = self::readCacheFile($cacheFile);
        return $content['content'];
    }

    private static function getCacheFilePath(string $key): string
    {
        return '../cache/' . $key;
    }

    private static function readCacheFile(string $cacheFile): array
    {
        $content = file_get_contents($cacheFile);
        return json_decode($content, true);
    }

    private static function writeCacheFile(string $cacheFile, array $data): void
    {
        $content = json_encode($data);
        file_put_contents($cacheFile, $content);
    }
}
