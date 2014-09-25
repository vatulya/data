<?php

namespace Model\Data\Source;

class Php extends AbstractSource
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
        $data = include $filename;

        return $this->prepareData($data);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function prepareData(array $data)
    {
        $preparedData = [];
        foreach ($data as $group => $groupData) {
            foreach ($groupData as $code => $itemData) {
                $item = [
                    'group' => $group,
                    'code' => $code,
                ];
                $preparedData[] = $item + $itemData;
            }
        }
        return $preparedData;
    }

}