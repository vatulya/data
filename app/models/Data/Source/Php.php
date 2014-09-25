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
        $data = $this->getDataFromFile();
        return $this->prepareData($data);
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    protected function getDataFromFile()
    {
        if (empty($this->config['filename'])) {
            throw new \Exception('Empty config');
        }
        $filename = APPLICATION_PATH . $this->config['filename'];
        if (!file_exists($filename)) {
            throw new \Exception('Can\'t find file "' . $filename . '"');
        }
        $data = @include $filename;
        if (!is_array($data)) {
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
            foreach ($data as $group => $groupData) {
                if (is_array($groupData)) {
                    foreach ($groupData as $code => $itemData) {
                        $item = [
                            'group' => $group,
                            'code' => $code,
                        ];
                        $preparedData[] = $item + $itemData;
                    }
                }
            }
        }
        return $preparedData;
    }

}