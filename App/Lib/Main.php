<?php


namespace App\Lib;

use App\Lib\DataObject;
use App\Lib\OutsourceManager;
use Exception;

class Main
{

    /**
     * Main constructor.
     */
    public function __construct(RabbitMainSender $rabbitSender, RabbitMainReceiver $rabbitReceiver)
    {
        // config
        $this->rabbitSender = $rabbitSender;
        $this->rabbitReceiver = $rabbitReceiver;

    }

    /**
     * Call run function to set the main task running
     * Fetches some arbitrary data
     * Sends data objects out to RabbitMainSender
     * which serializes each one and sends tnem to a queue
     * it then receives the processed objects back from RabbitMainReceiver
     * and carries on processing as it will
     */
    public function run()
    {
        // some test data to send
        $outData = $this->fetchData();
        $dataCount = count($outData);
        $this->rabbitSender->sendObjects($outData);

        $this->rabbitReceiver->setCount($dataCount);
        $inData = $this->rabbitReceiver->returnDataArray();

        if (empty($inData)) {
            throw new Exception('no data returned from rabbit');
        } else {
            $this->carryOnProcessing($inData);
        }

    }

    /**
     * Function to create some fake data
     *
     * @return DataObject[] array
     */
    protected function fetchData()
    {
        $arrayOfDataObjects = [];
        for($i=0; $i<5; $i++) {
            $dataObject = new DataObject();
            $arrayOfDataObjects[] = $dataObject;
        }

echo ("Sending out:\n");
print_r($dataObject);

        return $arrayOfDataObjects;
    }

    /**
     * @param $processedData
     */
    protected function carryOnProcessing($processedData)
    {

echo("Data after processing:\n");
print_r(array_shift($processedData));

        echo "\nThank you for listening!";

    }

}