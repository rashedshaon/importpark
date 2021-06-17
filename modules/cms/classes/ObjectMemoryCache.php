<?php namespace Cms\Classes;

/**
 * ObjectMemoryCache provides a simple request-level cache for CMS objects
 *
 * @package october\cms
 * @author Alexey Bobkov, Samuel Georges
 */
class ObjectMemoryCache
{
    /**
     * @var array cache collection
     */
    public static $cache = [];

    /**
     * has
     */
    public static function has($theme, string $fileName): bool
    {
        $cacheKey = static::makeCacheKey($theme, $fileName);

        return array_key_exists($cacheKey, static::$cache);
    }

    /**
     * get
     */
    public static function get($theme, string $fileName, CmsObject $instance): ?CmsObject
    {
        $cacheKey = static::makeCacheKey($theme, $fileName);

        $attributes = static::$cache[$cacheKey] ?? null;

        return $attributes ? $instance->newFromBuilder($attributes) : null;
    }

    /**
     * put
     */
    public static function put($theme, string $fileName, ?CmsObject $obj)
    {
        $cacheKey = static::makeCacheKey($theme, $fileName);

        static::$cache[$cacheKey] = $obj ? $obj->getAttributes() : null;
    }

    /**
     * makeCacheKey
     */
    protected static function makeCacheKey($theme, string $fileName): string
    {
        $themeDir = is_string($theme) ? $theme : $theme->getDirName();

        return "${themeDir}.${fileName}";
    }

    /**
     * flush
     */
    public static function flush()
    {
        static::$cache = [];
    }
}
