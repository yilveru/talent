<?php
class Data
{
    private $path_default = __DIR__ . '/../data/';
    private $_file = '';

    public function __construct($type)
    {
        $this->_file = $type . ".json";
    }

    /**
     * return data from json file
     * @return array
     */
    public function read()
    {
        if ($this->exists())
            return json_decode(file_get_contents($this->path_default . $this->_file), true);
        else
            return false;
    }

    /**
     * chech if file exists
     * @return boolean
     */
    public function exists()
    {
        if (file_exists($this->path_default . $this->_file))
            return true;
        else
            return false;
    }
    /**
     * save data
     * @param array $contents content to save like json
     * @return boolean
     */
    public function save($contents)
    {
        file_put_contents($this->path_default . $this->_file, json_encode($contents));
        return true;
    }
}
