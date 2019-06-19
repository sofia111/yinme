<?php

class XrefParser extends TCPDF_PARSER
{
    public function __construct($data, $cfg=array()) {
        if (empty($data)) {
            $this->Error('Empty PDF data.');
        }
        if (($trimpos = strpos($data, '%PDF-')) === FALSE) {
            $this->Error('Invalid PDF data: missing %PDF header.');
        }
        $this->pdfdata = substr($data, $trimpos);
        $this->setConfig($cfg);
        $this->xref = $this->getXrefData();
    }

    /**
     * 判断是否加密
     * @return boolean result
     */
    protected function isEncrypted()
    {
        if (isset($this->xref['trailer']['encrypt']))
            return true;
        return false;
    }

    /**
     * 判断是否可打印
     * @return boolean result
     */
    public function isPrint()
    {
        if ($this->isEncrypted()) {
            if (preg_match_all('/\/P\s(-?\d+)(?!\s0\sR)/', 
                $this->pdfdata, 
                $res) && 
                ((int)$res[1][0] & (1<<2))) {
                return true;
            }
            return false;
        }
        return true;
    }
}
