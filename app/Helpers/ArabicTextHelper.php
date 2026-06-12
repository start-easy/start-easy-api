<?php

namespace App\Helpers;

use ArPHP\I18N\Arabic;

class ArabicTextHelper
{
    protected Arabic $arabic;

    public function __construct()
    {
        $this->arabic = new Arabic('Glyphs');
    }

    /**
     * Recursively walk through an array or string
     * and reshape text, including array keys.
     *
     * @param mixed $data
     * @return mixed
     */
    public function reshape($data)
    {
        if (is_string($data)) {
            return $this->arabic->utf8Glyphs($data, 200, false, true);
        }

        if (is_array($data)) {
            $newData = [];
            foreach ($data as $key => $value) {
                $newKey = is_string($key) ? $this->arabic->utf8Glyphs($key, 200, false, true) : $key;

                $newValue = $this->reshape($value);

                $newData[$newKey] = $newValue;
            }
            return $newData;
        }

        return $data;
    }
}
