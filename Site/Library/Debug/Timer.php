<?php
namespace Site\Library\Debug;

class Timer
{
    private $_start;
    private $_end;

    public function __construct()
    {
            $this->_start = microtime(true);
    }

    public function Finish()
    {
            $this->_end = microtime(true);
    }

    private function GetStart()
    {
            if (isset($this->_start))
                    return $this->_start;
            else
                    return false;
    }

    private function GetEnd()
    {
            if (isset($this->_end))
                    return $this->_end;
            else
                    return false;
    }

    public function GetDiff()
    {
            return $this->GetEnd() - $this->GetStart();
    }

    public function Reset()
    {
            $this->_start = microtime(true);
    }

}