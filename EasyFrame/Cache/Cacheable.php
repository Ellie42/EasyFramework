<?php

namespace EasyFrame\Cache;

interface Cacheable{
    /**
     * Set the model data from array
     * @param array $data
     * @return mixed
     */
    public function setData(array $data);

    /**
     * Return the model data as array
     * @return array
     */
    public function getData();
}