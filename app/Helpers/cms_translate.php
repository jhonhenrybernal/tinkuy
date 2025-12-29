<?php

if (! function_exists('translate')) {
    /**
     * Get a translation for the given key from a dynamic directory.
     *
     * @param  string  $parent  The parent directory (e.g., 'cms', 'store')
     * @param  string  $key  The translation key (e.g., 'dashboard')
     * @param  string  $language  The language code (e.g., 'en', 'es')
     * @return string
     */
    function cms_translate($key)
    {

        // Build the translation key dynamically: 'cms.en.dashboard' or 'cms.es.dashboard'
        return trans('cms.'.$key);
    }
}
