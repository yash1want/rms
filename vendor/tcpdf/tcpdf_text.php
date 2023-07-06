<?php 

// TCPDF configuration
require_once(dirname(__FILE__).'/tcpdf_autoconfig.php');
// TCPDF static font methods and data
require_once(dirname(__FILE__).'/include/tcpdf_font_data.php');
// TCPDF static font methods and data
require_once(dirname(__FILE__).'/include/tcpdf_fonts.php');
// TCPDF static color methods and data
require_once(dirname(__FILE__).'/include/tcpdf_colors.php');
// TCPDF static image methods and data
require_once(dirname(__FILE__).'/include/tcpdf_images.php');
// TCPDF static methods and data
require_once(dirname(__FILE__).'/include/tcpdf_static.php');

class PDF_Rotate extends TCPDF
{
	var $angle=0;

	public function Header()
    {
        //Put the watermark
        $pdfBgText = (isset($_SESSION['pdfBgText'])) ? $_SESSION['pdfBgText'] : '';
        $pdfBgParam = $this->GetBgTextParam($pdfBgText);

        $this->SetFont('dejavuserifcondensed','B',$pdfBgParam['fontSize']);
        $this->SetTextColor( 205, 205, 205 );
        $this->RotatedText($pdfBgParam['lM'],$pdfBgParam['tM'],$pdfBgParam['text'],45);
    }
    
	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	function RotatedText($x, $y, $txt, $angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	function _endpage()
	{
		if($this->angle!=0)
		{
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}

    /**
     * Set watermark text parameter
     * @version 15th Jan 2022
     * @author Aniket Ganvir
     */
    function GetBgTextParam($pdfBgText)
    {
        $pdfBgParam = array();
        switch($pdfBgText) {

            case 'draft':
                $pdfBgParam['text'] = 'Draft';
                $pdfBgParam['fontSize'] = 110;
                $pdfBgParam['lM'] = 50;
                $pdfBgParam['tM'] = 150;
                break;
            case 'submit':
                $pdfBgParam['text'] = 'Final Submitted';
                $pdfBgParam['fontSize'] = 70;
                $pdfBgParam['lM'] = 25;
                $pdfBgParam['tM'] = 180;
                break;
            case 'approve':
                $pdfBgParam['text'] = 'Accepted';
                $pdfBgParam['fontSize'] = 90;
                $pdfBgParam['lM'] = 40;
                $pdfBgParam['tM'] = 180;
                break;
            default:
                $pdfBgParam['text'] = '';
                $pdfBgParam['fontSize'] = 110;
                $pdfBgParam['lM'] = 50;
                $pdfBgParam['tM'] = 150;

        }

        return $pdfBgParam;
    }

}

?>