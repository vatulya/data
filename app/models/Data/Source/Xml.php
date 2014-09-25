<?php

namespace Model\Data\Source;

class Xml extends AbstractSource
{

    /**
     * @return array
     * @throws \Exception
     */
    public function getData()
    {
        $filename = APPLICATION_PATH . $this->config['filename'];
        if (!file_exists($filename)) {
            throw new \Exception('Can\'t find file "' . $filename . '"');
        }
        $data = simplexml_load_file($filename);

        return $this->prepareData($data);
    }

    /**
     * @param \SimpleXMLElement $data
     * @return array
     */
    protected function prepareData(\SimpleXMLElement $data)
    {
        $preparedData = [];
        foreach ($data->Item as $item) {
            $preparedData[] = [
                'group' => (string)$item['Type'],
                'code' => (string)$item->Code,
                'value' => (float)$item->Value,
                'name' => (string)$item->Description,
            ];
        }
        return $preparedData;
    }

}