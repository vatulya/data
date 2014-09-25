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
        $filename = APPLICATION_PATH . $this->config['filename'];
        if (!file_exists($filename)) {
            throw new \Exception('Can\'t find file "' . $filename . '"');
        }
        $data = file_get_contents($filename);
        $data = json_decode($data);
        if (json_last_error()) {
            return [];
        }

        return $this->prepareData($data);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function prepareData($data)
    {
        $preparedData = [];
        foreach ($data as $row) {
            $preparedData[] = [
                'code' => getArrayValue($row, 0, ''),
                'name' => getArrayValue($row, 1, ''),
                'value' => getArrayValue($row, 2, 0),
                'group' => getArrayValue($row, 3, ''),
            ];
        }
        return $preparedData;
    }

}