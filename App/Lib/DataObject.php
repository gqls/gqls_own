<?php


namespace App\Lib;

use Exception;
use App\Lib\SerializableObjectInterface;

/**
 * Produce some random data for demonstration purposes
 *
 * Class DataObject
 * @package App\Lib
 */
class DataObject implements SerializableObjectInterface
{
    /**
     * Create sortable key from data
     *
     * @var
     */
    public $key;

    /**
     * Some random test data
     *
     * @var
     */
    protected $data;

    /**
     * Add some random data
     *
     * DataObject constructor.
     */
    public function __construct()
    {
        $this->data = ['a' => 'I start like this', 'b' => 'I start like this'];
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * This is just test data
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }


    /**
     * Serialize whatever is in $data array
     *
     * @return string
     */
    public function serializeObject()
    {
        return serialize($this);
    }

    /**
     * @param $serializedObject
     * @return DataObject
     * @throws Exception
     */
    public static function unserializeObject($serializedObject)
    {
        $unserialized = unserialize($serializedObject);
        if (false === $unserialized || null === $unserialized) {
            throw new Exception('unserialize produced nothing');
        }

        if ($unserialized instanceof DataObject) {
            return $unserialized;
        }

        throw new Exception('not a DataObject after unserialization');
    }

}