<?php

namespace App\Lib;


interface SerializableObjectInterface
{

    function serializeObject();
    static function unserializeObject($serializedObjecxt);
}