<?php
/*

 * File:        ReportXml.php
 *
 * Base class for all report output formats.
 * Defines base functionality for handling report
 * page headers, footers, group headers, group trailers
 * data lines
 *
 * @link http://www.reportico.org/
 * @copyright 2010-2014 Peter Deed
 * @author Peter Deed <info@reportico.org>
 * @package Reportico
 * @version $Id: swoutput.php,v 1.33 2014/05/17 15:12:31 peter Exp $
 */
namespace Reportico\Engine;

use SimpleXMLElement;

class ReportXml extends Report
{
    public $record_template;
    public $results = array();
    public $line_ct = 0;
    public function __construct()
    {
        $this->page_width = 595;
        $this->page_height = 842;
        $this->column_spacing = "2%";
    }

    public function start($engine = false)
    {

        Report::start();
        $title = $this->reporttitle;
        $this->results = array(
            "title" => $title,
            "timestamp" => date("Y-m-d\TH:i:s\Z", time()),
            "displaylike" => array(),
            "data" => array(),
        );

        $ct = 0;
    }

    public function finish()
    {
        Report::finish();
        $xmlroot = preg_replace("/\.xml$/", "", $this->query->xmloutfile);
        // print_r($xmlroot);exit;
        $xml = $this->arrayToXML($this->results, new SimpleXMLElement('<' . $xmlroot . '/>'))->asXml();
        // print_r($xml);exit;
        $len = strlen($xml);

        if (ob_get_length() > 0) {
            ob_end_clean();
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: text/xml');

        header("Content-Length: $len");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Disposition: inline; filename=reportico.xml');

        echo $xml;

        die;
    }

    public function arrayToXML1($root_element_name, $ar)
    {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><" . $root_element_name . "></" . $root_element_name . ">");
        $f = create_ReporticoLang::function('$f,$c,$a', '
            		foreach($a as $k=>$v) {
                		if(is_array($v)) {
                    		$ch=$c->addChild($k);
                    		$f($f,$ch,$v);
                		} else {
                    		$c->addChild($k,$v);
                		}
            		}');
        $f($f, $xml, $ar);
        return $xml->asXML();
    }
    public function arrayToXml(array $arr, SimpleXMLElement $xml)
    {
        // print_r($xml);exit;
        foreach ($arr as $k => $v) {
            if (is_array($v) && count($v) == 0) {
                continue;
            }

            if (preg_match("/^dataline_/", $k)) {
                $k = "dataline";
            }

            is_array($v) ? $this->arrayToXml($v, $xml->addChild($k)) : $xml->addChild($k, $v);
        }
        return $xml;
    }

    public function formatColumn(&$column_item)
    {
        if (!$this->showColumnHeader($column_item)) {
            return;
        }

        $k = &$column_item->column_value;
        $padstring = str_pad($k, 20);
    }

    public function eachLine($val)
    {
        Report::eachLine($val);

        // Set the values for the fields in the record
        $linekey = "dataline_" . ($this->line_ct + 1);
        $this->results["data"][$linekey] = array();

        if ($this->line_ct == 0) {
            $qn = ReporticoUtility::getQueryColumn("golap", $this->columns);
            if ($qn) {
                $arr = explode(",", $qn->column_value);
                foreach ($arr as $k => $v) {
                    $arr1 = explode("=", $v);
                    $this->results["displaylike"][$arr1[0]] = $arr1[1];
                }
            }
        }

        foreach ($this->query->display_order_set["column"] as $col) {
            $qn = ReporticoUtility::getQueryColumn($col->query_name, $this->columns);
            $coltitle = $col->deriveAttribute("column_title", $col->query_name);
            $coltitle = str_replace("_", " ", $coltitle);
            $coltitle = ucwords(strtolower($coltitle));
            $coltitle = ReporticoLang::translate($coltitle);

            $disp = $col->deriveAttribute("column_display", "show");
            if ($disp == "hide") {
                continue;
            }

            $this->results["data"][$linekey][preg_replace("/ /", "", $coltitle)] = $qn->column_value;

        }
        $this->line_ct++;

    }

}
