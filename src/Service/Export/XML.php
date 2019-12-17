<?php

namespace App\Service\Export;

/**
 * XML ExportMessage class.
 */
class XML extends ExportAbstract implements ExportInterface
{

    /**
     * @var String
     */
    protected $type = 'xml';

    public function export(array $data): void
    {
        $this->array2xml($data);
    }

    private  function array2xml($array, $xml = false)
    {
        if($xml === false) {
            $xml = new \SimpleXMLElement('<root/>');
        }

        foreach($array as $key => $value) {
            if(is_array($value)) {
                $this->array2xml($value, $xml->addChild('job'));
            } else {
                $xml->addChild($key, $this->applyConstraint($key, $value));
            }
        }

        return $xml->asXML($this->path);
    }

}
