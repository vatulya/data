<?php

namespace Model\Data\Source;

class Json extends AbstractSource
{

    /**
     * @return array
     * @throws \Exception
     */
    public function getData()
    {
        $data = $this->getDataFromFile();
        return $this->prepareData($data);
    }

    /**
     * @return array|mixed|string
     * @throws \Exception
     */
    protected function getDataFromFile()
    {
        $filename = APPLICATION_PATH . $this->config['filename'];
        if (!file_exists($filename)) {
            throw new \Exception('Can\'t find file "' . $filename . '"');
        }
        $data = file_get_contents($filename);
        $data = json_decode($data);
        if (json_last_error()) {
            $data = [];
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function prepareData(array $data)
    {
        $preparedData = [];
        if (is_array($data)) {
            foreach ($data as $row) {
                if (is_array($row)) {
                    $preparedData[] = [
                        'code' => (string)getArrayValue($row, 0, ''),
                        'name' => (string)getArrayValue($row, 1, ''),
                        'value' => (float)str_replace(',', '.', getArrayValue($row, 2, 0)),
                        'group' => (string)getArrayValue($row, 3, ''),
                    ];
                }
            }
        }
        return $preparedData;
    }

}