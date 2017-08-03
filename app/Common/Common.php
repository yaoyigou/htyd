<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-08-03
 * Time: 17:43
 */

namespace App\Common;


trait Common
{

    public function get_key($fh)
    {
        if (!empty($fh)) {
            return $fh . '.' . $this->primaryKey;
        }
        return $this->primaryKey;
    }
}