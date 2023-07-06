<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	use Cake\Datasource\ConnectionManager;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class LanguageComponent extends Component {
	
		public $components= array('Session');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		/**
		 * GET DYNAMIC FORM INPUT LABELS AS PER LANGUAGE & FORM NAME
		 * @param string $form_name
		 * @param string $lan
		 * @param int $form_no
		 * @param string $mineral
		 * @return array
		 * 
		 * @version 22nd Feb 2021
		 * @author Aniket Ganvir
		 */
		public function getFormInputLabels($form_name, $lan, $form_no=null, $mineral=null) {
			
			$label = array();
			$mc_form_main = $this->getController()->getRequest()->getSession()->read('mc_form_main');
			$return_type = $this->getController()->getRequest()->getSession()->read('returnType');
			$return_date = $this->getController()->getRequest()->getSession()->read('returnDate');
			$rule_no = ($mc_form_main == 1) ? "i" : (($mc_form_main == 2) ? "ii" : "iii");
			$rule_sec['en'] = ($return_type == 'MONTHLY') ? "b" : "c";
			$rule_sec['hn'] = ($return_type == 'MONTHLY') ? "बी" : "ग";

			$cost_unit = ($mc_form_main == 1) ? "tonne" : (($mc_form_main == 2) ? "unit" : "unit");
			$cost_unit_hn = ($mc_form_main == 1) ? "टन" : (($mc_form_main == 2) ? "इकाई" : "इकाई");
			

			// mine details
			if($form_name == 'mine') {
				if($lan == 'hindi') {

					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = ($return_type == 'MONTHLY') ? "भाग-1 (साधारण और श्रम)" : "भाग-1 (साधारण)";
					$label['title'] = "1. खान का ब्यौरा";
					$label[0] = "(क) भारतीय खान ब्यूरों द्धारा आवंटित रजिस्ट्रीकरण संख्या <br>( हस्ताक्षर करने वाले खान पट्टाधारी स्वामी के रजिस्ट्रीकरण नम्बर दें )";
					$label[1] = "(ख) खान कोड ( भारतीय खान ब्यूरों द्धारा आवंटित )";
					$label[2] = "(ग) खनिज का नाम";
					$label[3] = "(घ) खान का नाम";
					$label[4] = "(ड़) इसी खान से उत्पादित अन्य खनिजों के नाम, यदी कोई हो";
					$label[5] = (($return_type == 'MONTHLY') ? "(च)" : "2.")." खान की अवस्थिती";
					$label[6] = "ग्राम";
					$label[7] = "डाकघर";
					$label[8] = "तहसील - ताल्लुक";
					$label[9] = "जिला";
					$label[10] = "राज्य";
					$label[11] = "पिन कोड";
					$label[12] = "फैक्स सं.";
					$label[13] = "दूरभाष सं.";
					$label[14] = "मोबाईल सं.";
					$label[15] = "ईमेल";
					$label['btn'] = "अद्यतन";

				} else {

					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = ($return_type == 'MONTHLY') ? "PART-I (General and Labour)" : "PART-I (General)";
					$label['title'] = ($return_type == 'MONTHLY') ? "1. Details of the Mine" : '1. Details of Mine:';
					$label[0] = "(a) Registration number allotted by Indian Bureau of Mines <br><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(to give registration number of the Lessee-Owner)</em>";
					$label[1] = ($return_type == 'MONTHLY') ? "(b) <b>Mine Code</b> (allotted by Indian Bureau of Mines)" : "(b) Mine Code (allotted by Indian Bureau of Mines)";
					$label[2] = "(c) Name of the Mineral";
					$label[3] = "(d) Name of Mine";
					$label[4] = "(e) Name(s) of other mineral(s),<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if any, produced from the same mine";
					$label[5] = (($return_type == 'MONTHLY') ? "(f)" : "<b>2.</b>")." <b>Location of the Mine :</b>";
					$label[6] = "Village";
					$label[7] = "Post Office";
					$label[8] = "Tahsil-Taluk";
					$label[9] = "District";
					$label[10] = "State";
					$label[11] = "PIN Code";
					$label[12] = "Fax No. :";
					$label[13] = "Phone No. :";
					$label[14] = "Mobile:";
					$label[15] = "E-mail:";
					$label['btn'] = "Update";

				}
			}

			// name and address
			if($form_name == 'name_address') {
				if($lan == 'hindi') {

					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = ($return_type == 'MONTHLY') ? "भाग-1 (साधारण और श्रम)" : "भाग-1 (साधारण)";
					$label['title'] = (($return_type == 'MONTHLY') ? "2." : "3.") . " पट्टाधारक-स्वामी का नाम और पता <br>(फैक्स नं. और ईमेल सहित)";
					$label[0] = "पट्टाधारक-स्वामी का नाम";
					$label[1] = "पता";
					$label[2] = "जिला";
					$label[3] = "राज्य";
					$label[4] = "पिन कोड";
					$label[5] = "फैक्स सं.";
					$label[6] = "दूरभाष सं.";
					$label[7] = "मोबाईल सं.";
					$label[8] = "ईमेल";
					$label[9] = "4. पट्टाधारक का रजिस्ट्रीकरण कार्यालय";
					$label[10] = "5. प्रभारी निदेशक";
					$label[11] = "6. अभिकर्ता";
					$label[12] = "7. प्रबंधक";
					$label[13] = "8. खनन इंजीनियर प्रभारी";
					$label[14] = "9. भूवैज्ञानिक प्रभारी";
					$label[15] = "10.(i) स्थानांतरक (पूर्व स्वामी)";
					$label[16] = "(ii) स्थानांतरण की तारीख";
					$label[17] = "यदि कोई हो,और स्थानांतरण की तारीख ";
					$label[18] = "Upload Documents";
					$label[19] = "Download PMCP Format";
					$label[20] = "PMCP Table Format";
					$label[21] = "Upload PMCP Table in Excel";
					$label[22] = "View uploaded Excel file";
					$label[23] = "Excel file supported with max 2MB size.";
					$label[24] = "Upload UAV Survey (KML/KMZ File)";
					$label[25] = "Download KML/KMZ file";
					$label[26] = "KML, KMZ file supported with max 2MB size.";
					$label['btn'] = "अद्यतन";

				} else {

					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = ($return_type == 'MONTHLY') ? "PART-I (General and Labour)" : "PART-I (General)";
					$label['title'] = (($return_type == 'MONTHLY') ? "2." : "3.") . " Name and address of Lessee-Owner <br>(along with fax no. and e-mail):";
					$label[0] = "Name of Lessee-Owner";
					$label[1] = "Address";
					$label[2] = "District";
					$label[3] = "State";
					$label[4] = "PIN Code";
					$label[5] = "Fax No. :";
					$label[6] = "Phone No. :";
					$label[7] = "Mobile:";
					$label[8] = "E-mail:";
					$label[9] = "4. Registered Office of the Lessee";
					$label[10] = "5. Director in charge";
					$label[11] = "6. Agent";
					$label[12] = "7. Manager";
					$label[13] = "8. Mining Engineer in charge";
					$label[14] = "9. Geologist in charge";
					$label[15] = "10.(i) Transferer (previous owner)";
					$label[16] = "(ii) Date of transfer";
					$label[17] = "if any,and date of transfer:";
					$label[18] = "Upload Documents";
					$label[19] = "Download PMCP Format";
					$label[20] = "PMCP Table Format";
					$label[21] = "Upload PMCP Table in Excel";
					$label[22] = "View uploaded Excel file";
					$label[23] = "Excel file supported with max 2MB size.";
					$label[24] = "Upload UAV Survey (KML/KMZ File)";
					$label[25] = "Download KML/KMZ file";
					$label[26] = "KML, KMZ file supported with max 2MB size.";
					$label['btn'] = "Update";

				}
			}
				
			// rent details
			if($form_name == 'rent') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-1 (साधारण और श्रम)";
					$label['title'] = "3. मास के दौरान संदत्त किराए-स्वामिस्व-अनिवार्य भाटक डीएमएफ-एमएमईटी का ब्यौरा ";
					$label[0] = "(i) संदत्त किराया";
					$label[1] = "(ii) संदत्त स्वामिस्व";
					$label[2] = "(iii) संदत्त अनिवार्य भाटक";
					$label[3] = "(iv) डीएमएफ को संदत्त राशि";
					$label[4] = "(v) एमएमईटी को संदत्त राशि";
					
				} else {
					
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-I (General and Labour)";
					$label['title'] = "3. Details of Rent- Royalty - Dead Rent- DMF -NMET amount paid in the month";
					$label[0] = "(i) Rent paid";
					$label[1] = "(ii) Royalty paid";
					$label[2] = "(iii) Dead Rent paid";
					$label[3] = "(iv) Payment made to the DMF";
					$label[4] = "(v) Payment made to the NMET";
				}
			}

			// Part I: details on working
			if($form_name == 'working_detail') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-1 (साधारण और श्रम)";
					$label['title'] = "4. कार्यरत खान का ब्यौरा";
					$label[0] = "(i) खान में किए गए कार्य दिवसों की संख्या";
					$label[1] = "(ii) मास के दौरान खान में कार्य अवरुद्ध होने के कारण (हड़ताल, तालाबंदी, भारी वर्षा, श्रमिकों की अनुपलब्धता, परिवहन संबंधी बाधा, मांग में कमी अनार्थिक प्रचालन आदि) और प्रत्येक कारण से कार्य दिवसों की संख्या |";
					$label[2] = "कारण";
					$label[3] = "दिवसों की सं.";

				} else {
					
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-I (General and Labour)";
					$label['title'] = "4. Details on working of mine:";
					$label[0] = "(i) Number of days the mine worked:";
					$label[1] = "(ii) Reasons for work stoppage in the mine during the month (due to strike, lockout, heavy rain, non-availability of labour, transport bottleneck, lack of demand, uneconomic operations, etc.) and the number of days of work stoppage for each reason separately";
					$label[2] = "Reasons";
					$label[3] = "No of days";
				}
			}

			// Part I: average daily employment
			if($form_name == 'daily_average') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-1 (साधारण और श्रम)";
					$label['title'] = "5. औसत दैनिक नियोजन और संदत्त मजदूरी-वेतन #:";
					$label[0] = "कार्यस्थल";
					$label[1] = "जिला";
					$label[2] = "ठेके पर'";
					$label[3] = "कुल वेतन-मजदूरी (रु.)";
					$label[4] = "पुरुष";
					$label[5] = "स्त्री";
					$label[6] = "पुरुष";
					$label[7] = "स्त्री";
					$label[8] = "सीधी भर्ती";
					$label[9] = "ठेके पर";
					$label[10] = "भूमि के नीचे";
					$label[11] = "विवृत";
					$label[12] = "भूमि के ऊपर";
					$label[13] = "कुल";
					$label[14] = "# खनन स्थल पर खान और सम्बद्ध कारखाना, कर्मशाला या खनिज ड्रेसिंग संयंत्र के अनन्य सभी कर्मचारियों सहित";
					
				} else {
					
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-I (General and Labour)";
					$label['title'] = "5. Average Daily Employment and Total Salary-Wages paid #:";
					$label[0] = "Work place";
					$label[1] = "Direct";
					$label[2] = "Contract";
					$label[3] = "Total Salary-Wages (₹)";
					$label[4] = "Male";
					$label[5] = "Female";
					$label[6] = "Male";
					$label[7] = "Female";
					$label[8] = "Direct";
					$label[9] = "Contract";
					$label[10] = "Below ground";
					$label[11] = "Opencast";
					$label[12] = "Above ground";
					$label[13] = "Total";
					$label[14] = "# To include all employees exclusive to the mine and attached factory, workshop or mineral dressing plant at the mine site";
				}
			}


			// Part II: Type of Ore
			if($form_name == 'ore_type') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (i) देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "1. उत्पादित अयस्क का प्रकार:";
					$label['sub-title'] = "<br/><small><em>(केवल लोह अयस्क हेतु लागू ; जहां लागू हो, वहां सही चिन्ह करें )</em></small>";
					$label[0] = "हेमेटाइट";
					$label[1] = "मैग्नेटाइट";
					$label[2] = "उत्पादित अयस्क का प्रकार:";
					$label[3] = "(मात्रा टन में)";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (i)";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "1. Type of ore produced:";
					$label['sub-title'] = "<br/><small><em>(Applicable for iron ore only;tick mark whichever is applicable)</em></small>";
					$label[0] = "Hematite";
					$label[1] = "Magnetite";
					$label[2] = "Type of ore produced:";
					$label[3] = "(Unit of Quantity in Tonnes)";
				}
			}
			
			// Part II: Production/stocks (ROM)
			// if(in_array($form_name,['F11','F21','F32','F41','F51','F61','F72','F81'])) {
			if($form_name == 'rom_stocks') {
				$section_no = ($form_no == 1) ? '2' : '1';
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (i) देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['part-sub'] = "(प्रत्येक खनिज  के  लिए पृथक रूप से  प्रस्तुत किया जाए )";
					$label['title'] = $section_no.". खान शीर्ष पर आरओएम अयस्क का उत्पादन एंव स्टॉक";
					$label['title-1'] = "2. खान शीर्ष पर आरओएम अयस्क का उत्पादन एंव स्टॉक";
					$label[0] = "श्रेणी";
					$label[1] = "प्रारंभिक स्टॉक";
					$label[2] = "उत्पादन";
					$label[3] = "अंतिम स्टॉक'";
					$label[4] = "(क) विवृत खनिज";
					$label[5] = "(ख) भूमि के नीचे";
					$label[6] = "(ग) क्षेपण कार्य";
					$label[7] = "चालू वित्त वर्ष के लिए उत्पादन प्रस्ताव";
					$label[8] = "चालू महीने तक संचयी उत्पादन";
					$label[9] = "अंतर";
					$label[10] = "(मात्रा टन में)";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (i)";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['part-sub'] = "(To be submitted separately for each mineral)";
					$label['title'] = $section_no.". Production and Stocks of ROM ore at Mine-head";
					$label['title-1'] = "2. Production and Stocks of ROM ore at Mine-head";
					$label[0] = "Category";
					$label[1] = "Opening stock";
					$label[2] = "Production";
					$label[3] = "Closing stock";
					$label[4] = "(a) Open Cast workings";
					$label[5] = "(b) Underground Workings";
					$label[6] = "(c) Dump workings";
					$label[7] = "Production proposal for current financial year";
					$label[8] = "Cumulative production as reported upto the current month";
					$label[9] = "Difference";
					$label[10] = "(Unit of Quantity in Tonnes)";
				}
			}

			// Part II: Grade-wise Production
			if($form_name == 'gradewise_prod') {
				$formType = $this->getController()->getRequest()->getSession()->read('mc_form_type');
				$chemRep = $this->getController()->getRequest()->getSession()->read('chemRep');
				$section_no = ($form_no == 1) ? '3' : '2';

				//By refering Form F1 Part 2.2, we have checked all forms i.e F & G in mcdr there was no label as "Grades(% XX)", so beacause of this reason we have added condition as "$formType != 101". if you found "Grades(% XX)" in mcdr please update condition only, else you will have to check all forms F & G again.
				//Reviewed and checked By Shweta A. and Amey S. on 29/1/2022

				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (i) देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = $section_no."(i) खान-शीर्ष से ($) श्रेणीवार आरओयम अयस्क प्रेषण";
					$label['title-1'] = "3(i) खान-शीर्ष से ($) श्रेणीवार आरओयम अयस्क प्रेषण:";
					$label[0] = "आरओएम का श्रेणी@";
					$label[1] = "खान-शीर्ष से प्रेषण";
					$label[2] = "खान पर मूल्य (रु.)";
					$label['note'] = "($): केवल लौह अयस्क और क्रोमाइट के लिए लागु प्रेषण के अन्य खनिज आंकड़ा हेतु 3(ii) में सूचना दी जनि हैं| ";
					$label['title_two'] = $section_no."(ii) श्रेणीवार उत्पादन, प्रेषण, स्टॉक और पूर्व खान मूल्य";
					$label['title_two-1'] = "3(ii) श्रेणीवार उत्पादन, प्रेषण, स्टॉक और पूर्व खान मूल्य:";
					$label[3] = ($formType != 101) ? "श्रेणियां**" :"श्रेणियां(% of " . html_entity_decode($chemRep) . " content)";
					$label['3-1'] = "श्रेणियां**";
					$label[4] = "खान-शीर्षक में प्रारंभिक स्टॉक";
					$label[5] = "उत्पादन";
					$label[6] = "खान शीर्ष से प्रेषण";
					$label[7] = "खान शीर्ष में बंद होने पर स्टॉक";
					$label[8] = "खान पर मूल्य <br>(रूपए-एमटी)";
					$label[9] = "औसत श्रेणी";
					$label['note_2'] = "<em>Note.---</em> Any kind of Hematite Iron Ore below 45% Fe but above threshold value shall be included in the grade slab of'45% to below 51% Fe'.";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (i)";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = $section_no."(i) Grade-wise ROM ore despatches from mine head ($)";
					$label['title-1'] = "3(i) Grade-wise ROM ore despatches from mine head ($):";
					$label[0] = "Grade of ROM@";
					$label[1] = "Despatches from mine-head";
					$label[2] = "Ex-mine Price (₹)";
					$label['note'] = "($): Applicable for iron ore and chromite only. For other minerals data of dispatches to be reported in 3(ii)";
					$label['title_two'] = $section_no."(ii) Grade-wise Production, Dispatches, Stocks and Ex-mine prices";
					$label['title_two-1'] = "3(ii) Grade-wise Production, Dispatches, Stocks and Ex-mine prices:";
					$label[3] = ($formType != 101) ? "Grades**" :"Grades(% of " . html_entity_decode($chemRep) . " content)";
					$label['3-1'] = "Grades**";
					$label[4] = "Opening stock at mine-head";
					$label[5] = "Production";
					$label[6] = "Despatches from mine-head";
					$label[7] = "Closing stock at mine-head";
					$label[8] = "Ex-mine price <br>(₹-Tonne)";
					$label[9] = "Average Grade";
					$label['note_2'] = "<em>Note.---</em> Any kind of Hematite Iron Ore below 45% Fe but above threshold value shall be included in the grade slab of'45% to below 51% Fe'.";
				}
			}
			
			// Part II: Pulverisation
			// if(in_array($form_name,['F34','F74'])) {
			if($form_name == 'pulverisation') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (i) देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "3. चूर्ण";
					$label['title-1'] = "3(iii) यदि खनिज को अपनी कारखाने में ही पीसा जा रहा है तो कृपया निम्न विशिष्टियां दें:";
					$label[0] = "खनिज निजी कारखाना में पीसा जा रहा है ?";
					$label[1] = "हा";
					$label[2] = "ना";
					$label[3] = "3. (i) यदि खनिज को अपनी कारखाने में ही पीसा जा रहा है तो कृपया निम्न विशिष्टियां दें";
					$label[4] = "श्रेणी**";
					$label[5] = "पीसे खनिज की कुल मात्रा (टन में)";
					$label[6] = "पिसा खनिज उत्पादन की कुल मात्रा (प्रत्येक मेश आकर हेतु)";
					$label[7] = "मास के दौरान बेचे गये पिसे खनिज की कुल मात्रा";
					$label[8] = "मेश आकर";
					$label[9] = "मात्रा (टन)";
					$label[10] = "मेश आकर";
					$label[11] = "मात्रा (टन)";
					$label[12] = "कारखाना पर विक्रय मूल्य(₹)";
					$label[13] = "और जोड़ें";
					$label[14] = "हटाएँ";
					$label[15] = "3.(ii) चूर्ण की औसत लागत";
					$label['15-1'] = "3(iv) चूर्ण की औसत लागत (*) : ₹ ";
					$label[16] = "चूर्ण की औसत लागत:";
					$label[17] = "प्रति टन";
					$label['note'] = "लौह अयस्क, मैंगनीज अयस्क, बॉक्साइट और क्रोमाइट के लिए लागू नहीं";

					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (i)";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "3. Pulverization";
					$label['title-1'] = "3(iii) In case the mineral is being pulverized in own factory, please give the following particulars (*):";
					$label[0] = "Is mineral being pulverized in own factory?";
					$label[1] = "Yes";
					$label[2] = "No";
					$label[3] = "3. (i) In case the mineral is being pulverized in own factory, please give the following particulars(*)";
					$label[4] = "Grade**";
					$label[5] = "Total quantity of mineral Pulverized<br><br>(in tonnes)";
					$label[6] = "Total quantity of pulverized mineral produced<br>(for each mesh size)";
					$label[7] = "Total Quantity of pulverized mineral sold during the month";
					$label[8] = "Mesh size";
					$label[9] = "Quantity<br>(tonne)";
					$label[10] = "Mesh size";
					$label[11] = "Quantity<br>(tonne)";
					$label[12] = "Ex-factory Sale value<br>(₹)";
					$label[13] = "Add more";
					$label[14] = "Remove";
					$label[15] = "3. (ii) Average cost of pulverization";
					$label['15-1'] = "3(iv) Average cost of pulverization (*) : ₹ ";
					$label[16] = "Average cost of Pulverization(*):";
					$label[17] = "per tonne";
					$label['note'] = "(*): Not applicable for Iron ore, Manganese ore, Bauxite and Chromite";
				}
			}

			// Part II: Details of Deductions
			if(in_array($form_name,['deduct_detail'])) {
				$section_no = ($form_no == 2) ? '3' : '4';
				//changed for F3 Part-2.3 By Amey S.
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = ($mc_form_main == '1') ? $section_no.". विक्रय मूल्य की गणना के लिए प्रयुक्त कटौती का ब्यौरा (खान मूल्य) (₹ - टन)" : (($mc_form_main == '2') ? "6. खान पर (रु.-यूनिट) विक्री मूल्य की गणना करने के लिए विक्री मूल्य में से की गई कटौतियों का ब्यौरे" : "3. विक्रय मूल्य की गणना के लिए प्रयुक्त कटौती का ब्यौरा (खान मूल्य) (₹ - यूनिट)");
					$label['title-1'] = "4. Details of deductions made from sale value for computation of Ex-mine price (₹- Tonne)";
					$label['title-2'] = "6. Details of deductions made from sale value for computation of Ex-mine price (₹- Unit)";
					$label['title-3'] = "3. Details of deductions made from sale value for computation of Ex-mine price (₹- Unit)";
					$label[0] = "कटौती का दावा #";
					$label[1] = ($mc_form_main == '1') ? "राशि (₹ - टन में)" : "राशि (₹ - यूनिट में)";
					$label['1-1'] = "राशि<br>(₹ - टन में)";
					$label['1-2'] = "राशि (₹ - यूनिट में)";
					$label[2] = "टिप्पणियां";
					$label[3] = "(क) परिवहन की लागत (टिप्पणियों में लदान स्थल और खान से दूरी दर्शाएं)";
					$label[4] = "(ख) लदान और माल उतारने के प्रभार";
					$label[5] = "(ग) रेल भाड़ा, यदि लागू हो तो (गंतव्य और दूरी दर्शाएं)";
					$label[6] = "(घ) पोर्ट हथलाई प्रभार-निर्यात शुल्क (पोर्ट का नाम दर्शाएं)";
					$label[7] = "(ड़) नमूना और विश्लेषण प्रभार";
					$label[8] = "(च) स्टॉकिंग यार्ड में संयंत्र के लिए किराया";
					$label[9] = "(छ) अन्य प्रभार (स्पष्ट रूप से दर्शाएं)";
					$label[10] = "कुल (क) से (छ)";
					$label['note'] = "# खपत प्रेषण और खान पर विक्रयों के लिए लागु नहीं |";


				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['part-sub'] = "";
					$label['title'] = ($mc_form_main == '1') ? $section_no.". Details of deductions made from sale value for computation of Ex-mine price (₹ - Tonne)" : (($mc_form_main == '2') ? "6. Details of deductions made from sale value for computation of Ex-mine price (₹- Unit)" : "3. Details of deductions made from sale value for computation of Ex-mine price (₹ - Unit)");
					$label['title-1'] = "4. Details of deductions made from sale value for computation of Ex-mine price (₹- Tonne)";
					$label['title-2'] = "6. Details of deductions made from sale value for computation of Ex-mine price (₹- Unit)";
					$label['title-3'] = "3. Details of deductions made from sale value for computation of Ex-mine price (₹- Unit)";
					$label[0] = "Deduction claimed #";
					$label[1] = ($mc_form_main == '1') ? "Amount (₹ - Tonne)" :  "Amount ( in ₹ - Unit)";
					$label['1-1'] = "Amount<br>( in ₹- Tonne)";
					$label['1-2'] = "Amount ( in ₹ - Unit)";
					$label[2] = "Remarks";
					$label[3] = "(a) Cost of transportation <br>(indicate loading station and distance from mine in remarks)";
					$label[4] = "(b) Loading and unloading charges";
					$label[5] = "(c) Railway freight, if applicable <br>(indicate destination and distance)";
					$label[6] = "(d) Port Handling charges- export duty <br>(indicate name of port)";
					$label[7] = "(e) Charges for sampling and analysis";
					$label[8] = "(f) Rent for the plot at Stocking yard";
					$label[9] = "(g) Other charges <br>(specify clearly)";
					$label[10] = "Total (a) to (g)";
					$label['note'] = "# Not applicable for captive dispatches and ex-mine sales";
				}
			}

			// Part II: Sales/Dispatches
			if(in_array($form_name,['sale_despatch'])) {
				$section_no = ($form_no == 2) ? 4 : 5;
				$sec_no = ($mc_form_main == 1) ? $section_no : (($mc_form_main == '2') ? 7 : 4);
				$return_type_label  = ($return_type == 'MONTHLY') ? "month" : "year";
				$return_type_label_hin  = ($return_type == 'MONTHLY') ? "मास" : "वर्ष";
				$checkform5  = ($form_no == 5);
				$checkform7  = ($form_no != 7);

				if ($lan == 'hindi'){
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = ($mc_form_main == 1) ? $section_no.". देशी खपत और निर्यात के लिए की गई बिक्री-प्रेषण" : (($mc_form_main == '2') ? "7. देशी प्रयोजन और निर्यात के लिए अयसक और सांद्रणों की बिक्री-प्रेषण" : "4. देशी खपत और निर्यात के लिए की गई बिक्री-प्रेषण");
					$label['title-1'] = "5. Sales- Despatches effected for Domestic Purposes and for Exports:";
					$label['title-2'] = "7. Sales- Dispatches of ore and concentrates effected for Domestic Purposes and for Exports:";
					$label['title-3'] = "4. Sales- Despatches effected for Domestic Purposes and for Exports:";
					$label[0] = "देशी खपत के लिए";
					$label[1] = "निर्यात के लिए";
					$label[2] = $checkform5 ? "श्रेणी (अयस्क-सान्द्र.)" : ($checkform7 ? "श्रेणी(^)" : "श्रेणी(*)");
					// $label['2-1'] = "श्रेणी<br>(^)";
					$label['2-1'] = "श्रेणी";
					$label['2-2'] = "श्रेणी (अयस्क-सान्द्र.)";
					$label['2-3'] = "श्रेणी<br>(*)";
					$label[3] = "प्रेषण का प्रकार (दर्शाएं की क्या बिक्री अथवा देशी हस्तांतरण अथवा गृहीत खपत अथवा निर्यात के लिए है)";
					$label[4] = "क्रेता की आईवीएम द्वारा यथाआवंटित रजिस्ट्रीकरण ##";
					$label[5] = "प्रेषिती  नाम ##";
					$label[6] = "मात्रा";
					$label[7] = "विक्रय मूल्य (₹)";
					$label[8] = "देश";
					$label[9] = "मात्रा";
					$label[10] = "एफओबी मूल्य (₹)";
					$label[11] = ($sec_no+1).". उत्पादन में वृद्धि / कमी का कारण";
					$label[12] = ($sec_no+2).". एक्स-माइन मूल्य में वृद्धि / कमी का कारण";
					$label[13] = "पिछले ".$return_type_label_hin." की तुलना में इस ".$return_type_label_hin." के दौरान उत्पादन-शुन्य उत्पादन में वृद्धि-कमी के यदि कोई कारन हो तो दीजिए |";
					$label['reason-1-1'] = "6. Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-1-2'] = "8. Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-1-3'] = "5. Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label[14] = "पिछले ".$return_type_label_hin." की तुलना में इस ".$return_type_label_hin." के दौरान, श्रेणीवार खान मूल्य में वृद्धि कमी यदि कोई हो तो दीजिए |";
					$label['reason-2-1'] = "7. Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-2-2'] = "9. Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-2-3'] = "6. Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['note1'] = "## यदि क्रेता एक से अधिक हो तो अलग विनिर्दिष्ट करें |";
					$label['note'] = $checkform7 ? "<b>नोट:</b> खान मालिक को इनवॉइस की प्रति के साथ ऊपर उद्धृत प्रत्येक ग्रेड के लिए घरेलू बिक्री मूल्य / एफओबी मूल्य को प्रमाणित करना आवश्यक है (रिटर्न के साथ प्रस्तुत नहीं किया जाना चाहिए; जब भी आवश्यक हो)" : "टिप्पण: खान स्वामियों को दर्शाए गए सभी श्रेणियों के देशी विक्री मूल्य - एफओबी को बीजक की एक प्रति के साथ प्रमाणित करना होगा (विवरणी के साथ नहीं दिया जाना चाहिए, यथा आवश्यक प्रस्तुत की जाए ) ";
					$label['note-1'] = "NOTE:- Mine owners are required to substantiate domestic sale value- FOB value for each grade of ore quoted above with copy of invoices (not to be submitted with the return; to be produced whenever required)";
					$label['note-2'] = "NOTE:- Mine owners are required to substantiate domestic sale value- FOB value for each grade quoted above with copy
					of invoices (not to be submitted with the return; to be produced whenever required).";
					$label['note-3'] = "NOTE:- Mine owners are required to substantiate domestic sale value- FOB value for each grade of ore quoted above
					with copy of invoices (not to be submitted with the return; to be produced whenever required).";
					$label['note3'] = "*: कच्चे और बिना कटे पत्थरों, कटे और पॉलिश किए गए पत्थरों, औद्योगिक, अन्य को इंगित करने के लिए";
					$label['note4'] = $checkform5 ? "" : "(^): यथा अधोवर्णित अयस्क की श्रेणी को दर्शाएं (देखें @ और **)";
					
				}
				else{
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = ($mc_form_main == '1') ? $section_no.". Sales- Despatches effected for Domestic Purposes and for Exports" : (($mc_form_main == '2') ? "7. Sales/Despatches of Ore and Concentrates effected for Domestic Purposes and for Exports" : "4. Sales- Dispatches effected for Domestive Purposes and for Exports");
					$label['title-1'] = "5. Sales- Despatches effected for Domestic Purposes and for Exports:";
					$label['title-2'] = "7. Sales- Dispatches of ore and concentrates effected for Domestic Purposes and for Exports:";
					$label['title-3'] = "4. Sales- Despatches effected for Domestic Purposes and for Exports:";
					$label[0] = "For Domestic Purposes";
					$label[1] = "For export";
					$label[2] =  $checkform5 ? "Grade (ore-Conc.)" : ($checkform7 ? "Grade(^)" : "Grade(*)") ;
					// $label['2-1'] = "Grade<br>(^)";
					$label['2-1'] = "Grade";
					$label['2-2'] = "Grade (ore-Conc.)";
					$label['2-3'] = "Grade<br>(*)";
					$label[3] = "Nature of Despatch <em>(indicate whether Domestic Sale or Domestic Transfer or Captive consumption or Export)</em>";
					$label[4] = "Registration number as allotted by the Indian Bureau of Mines to the buyer ##";
					$label[5] = "Consignee name ##";
					$label[6] = "Quantity";
					$label[7] = "Sale value (₹)";
					$label[8] = "Country";
					$label[9] = "Quantity";
					$label[10] = "F.O.B Value (₹)";
					$label[11] = ($sec_no+1).". Reason for increase/decrease in Production";
					$label[12] = ($sec_no+2).". Reason for increase/decrease in Ex-mine price";
					$label[13] = "Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label;
					$label['reason-1-1'] = "6. Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-1-2'] = "8. Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-1-3'] = "5. Give reasons for increase-decrease in production-nil production, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label[14] = "Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label;
					$label['reason-2-1'] = "7. Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-2-2'] = "9. Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['reason-2-3'] = "6. Give reasons for increase-decrease in grade wise ex-mine price, if any, during the ".$return_type_label." compared to the previous ".$return_type_label.".";
					$label['note1'] = "## To indicate separately if more than one buyer.";
					$label['note'] = $checkform7 ? "<b>Note</b>: Mine owner are required to Substantiate domestic Sale Value / FOB value for each grade quoted above with copy of invoices (not to be submitted with the return; to be produced whenever required)" : "NOTE: Mine owner are required to Substantiate domestic Sale Value - FOB value for each grade of ore quoted above with copy of invoices (not to be submitted with the return; to be produced whenever required).";
					$label['note-1'] = "NOTE:- Mine owners are required to substantiate domestic sale value- FOB value for each grade of ore quoted above with copy of invoices (not to be submitted with the return; to be produced whenever required)";
					$label['note-2'] = "NOTE:- Mine owners are required to substantiate domestic sale value- FOB value for each grade quoted above with copy
					of invoices (not to be submitted with the return; to be produced whenever required).";
					$label['note-3'] = "NOTE:- Mine owners are required to substantiate domestic sale value- FOB value for each grade of ore quoted above
					with copy of invoices (not to be submitted with the return; to be produced whenever required).";
					$label['note3'] = "*: To indicate rough and uncut stones, cut and polished stones, industrial, others";
					$label['note4'] =  $checkform5 ? "" : ( $checkform7 ? "(^): To indicate the grades of ores as mentioned below(see @ and **)" : "*:To indicate rough and uncut stones, cut and polished stones,industrial,others" );
				}
				
			}

			// Part II: Production and Stocks of ROM ore
			if($form_name == 'rom_stocks_ore') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['part-sub'] = "(प्रत्येक खनिज  के  लिए पृथक रूप से  प्रस्तुत किया जाए ) <br/> (मात्र की इकाई टन  में : यदि टन में नहीं  तो इकाई दर्शाए) ";
					$label['title'] = "1. आर ओएम का उत्पादन और स्टॉक";
					$label[0] = "प्रारंभिक स्टॉक (टन में)";
					$label[1] = "उत्पादन (टन में)";
					$label[2] = "स्टॉक (टन में)";
					$label[3] = "मात्रा'";
					$label[4] = "धातु मात्रा/श्रेणी";
					$label[5] = "क(i).विकास से (भूमिगत कार्य से)";
					$label[6] = "क(ii).स्टोपिंग से (भूमिगत कार्य से)";
					$label[7] = "क. भूमिगत कार्य से (कुल)";
					$label[8] = "ख. विवृत कार्यों से";
					$label[9] = "कुल";
					$label[10] = "खनिज का नाम";
					$label[11] = "वित्तीय वर्ष के लिए उत्पादन प्रस्ताव";
					$label[12] = "वित्तीय वर्ष के दौरान रिपोर्ट किया गया उत्पादन";
					$label[13] = "चालू वित्तीय वर्ष के लिए उत्पादन प्रस्ताव";
					$label[14] = "चालू माह तक रिपोर्ट के अनुसार संचयी उत्पादन";
					$label[15] = "अंतर";
					$label['btn'] = "और जोड़ें";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['part-sub'] = "(To be submitted separately for each mineral) <br/ > (Unit of Quantity in Tonnes; indicate unit of quantity if not in tonnes)";
					$label['title'] = "1. Production and Stocks of ROM ore";
					$label[0] = "Opening stocks";
					$label[1] = "Production";
					$label[2] = "Closing stocks";
					$label[3] = "Quantity";
					$label[4] = "Metal content/grade";
					$label[5] = "i) From Development";
					$label[6] = "ii) From Stoping";
					$label[7] = "A. From Underground workings";
					$label[8] = "B. From Opencast workings";
					$label[9] = "Total";
					$label[10] = "Mineral Name";
					$label[11] = "Production proposal for financial year";
					$label[12] = "Production reported during the financial year";
					$label[13] = "Production proposal for current financial year";
					$label[14] = "Cumulative production as reported upto the current month";
					$label[15] = "Difference";
					$label['btn'] = "Add more";
				}
			}

			// Part II: Ex-Mine Price
			if($form_name == 'ex_mine') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "6";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "2. उत्पादित अयस्क की खान पर कीमत";
					$label[0] = "उत्पादित अयस्क की खान पर कीमत (प्रति इकाई रु.) में";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "2. Ex-mine price of the ore produced (₹ per unit):";
					$label[0] = "Ex-mine price of the ore produced (₹ per unit)";
				}
			}

			// Part II: Recoveries at Concentrator
			if($form_name == 'con_reco') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "6";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "3. सांद्रक/मिल/संयंत्र पर वसूलियां (मात्रा टन में और मूल्य रुपये में)";
					$label[0] = "कंसन्ट्रेटर-संयंत्र में अयस्क का प्रारंभिक स्टॉक";
					$label[1] = "खान से प्राप्त अयस्क";
					$label[2] = "शोधित अयस्क";
					$label[3] = "मात्रा'";
					$label[4] = "धातु मात्रा / श्रेणी";
					$label[5] = "सांद्रण * प्राप्त";
					$label[6] = "टेलिंग्स";
					$label[7] = "सांद्रक-संयंत्र पर सांद्रण का अंतिम स्टॉक";
					$label[8] = "मात्रा (टन में)";
					$label[9] = "धातु मात्रा / श्रेणी";
					$label[10] = "कीमत (रु.)";
					$label[11] = "यदि निक्षालन पद्धति अपनाई गई है तो प्राप्त की गई मात्रा और श्रेणी का विनिर्दिष्ट अलग करें";
					$label['btn'] = "और जोड़ें";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "3. Recoveries at Concentrator-Mill-Plant:";
					$label[0] = "Opening stocks of the Ore at concentrator-plant";
					$label[1] = "Ore received from the mine";
					$label[2] = "Ore treated";
					$label[3] = "Quantity";
					$label[4] = "Metal content-grade";
					$label[5] = "Concentrates * Obtained";
					$label[6] = "Tailings";
					$label[7] = "Closing stocks of concentrates at the concentrator-plant";
					$label[8] = "Quantity";
					$label[9] = "Metal content/grade";
					$label[10] = "Value (₹)";
					$label[11] = "In case of any leaching method adopted, give quantity recovered and grade contained separately.";
					$label['btn'] = "Add more";
				}
			}

			// Part II: Recovery at the Smelter
			if($form_name == 'smelt_reco') {
				$smelt_reco_sep = ($return_type == 'MONTHLY') ? '/' : '-';
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "4. प्रगालक -मिल-संयंत्र पर वसूली";
					$label[0] = "प्रगाल -संयंत्र पर सांद्रणों का प्रारंभिक स्टॉक";
					$label[1] = "सांद्रक-संयंत्र से प्राप्त सांद्रण";
					$label[2] = "अन्य स्त्रोतों से प्राप्त सांद्रण (विशेष विनिर्दिष्ट करें)";
					$label[3] = "विक्रय किये गए सांद्रण (यदि कोई हों)";
					$label[4] = "शोधित सांद्रण ";
					$label[5] = "स्मेल्टर-संयंत्र पर सांद्रण का अंतिम स्टॉक ";
					$label[6] = "मात्रा (टन में)";
					$label[7] = "धातु मात्रा".$smelt_reco_sep." श्रेणी";
					$label[8] = "स्रोत";
					$label[9] = "धातु(*) प्राप्त (विशेष विनिर्दिष्ट करें)";
					$label[10] = "प्राप्त अन्य उप-उत्पाद यदि कोई हो";
					$label[11] = "मात्रा";
					$label[12] = "श्रेणी";
					$label[13] = "कीमत (रु.)";
					$label['note'] = "(*) कृपया प्रवर्गवार ब्यौरा दें यथा ब्लिस्टर, फायर रिफाइंड ताम्र, कैथोड, एलेक्ट्रोलेटिक, ताम्र तार छड़ें, सिमा इंगोस्ट्स, ज़िंक कैथोड, ज़िंक ड्रोस, स्वर्ण, टंगस्टन आदि |";
					$label['btn'] = "और जोड़ें";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "4. Recovery at the Smelter-Mill-Plant:";
					$label[0] = "Opening Stocks of the concentrates at the smelter -plant";
					$label[1] = "Concentrates received from concentrator-plant";
					$label[2] = "Concentrates received from other sources <br>(specify)";
					$label[3] = "Concentrates sold <br>(if any)";
					$label[4] = "Concentrates treated";
					$label[5] = "Closing stocks of concentrate at the Smelter-Plant";
					$label[6] = "Quantity";
					$label[7] = "Metal content".$smelt_reco_sep." grade";
					$label[8] = "Source";
					$label[9] = "Metals(*) recovered (specify)";
					$label[10] = "Other by-products, if any, recovered";
					$label[11] = "Quantity";
					$label[12] = "Grade";
					$label[13] = "Value (₹)";
					$label['note'] = "(*) Please give category-wise break-up viz. blister, fire refined copper, cathodes, electrolytic copper wire bars, lead ingots, zinc cathodes, zinc dross, gold, tungsten etc.";
					$label['btn'] = "Add more";
				}
			}

			// Part II: Sales (Metals/by Product)
			if($form_name == 'sales_metal_product') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "5. मास के दौरान विक्री";
					$label[0] = "धातु-उत्पाद का प्रारंभिक स्टॉक";
					$label[1] = "विक्रयस्थान";
					$label[2] = "विक्री किए गए धातु-उत्पाद <span>(@)</span>";
					$label[3] = "धातुओं-उत्पादों अंतिम स्टॉक";
					$label[4] = "धातु-उत्पाद";
					$label[5] = "मात्रा";
					$label[6] = "श्रेणी";
					$label[7] = "कीमत <span>#</span> (रु.)";
					$label['btn'] = "और जोड़ें";
					$label['note_txt'] = "टिप्पण:";
					$label['note_1'] = "(#) कृपया पूर्व संयंत्र पर बिक्री मूल्य दें |";
					$label['note_2'] = "(@) कृपया प्रवर्गवार बेचे गए धातुओं और अन्य उत्पादों का ब्यौरा दें |";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "5. Sales during the month:";
					$label[0] = "Opening stocks of Metals-Products";
					$label[1] = "Place of sale";
					$label[2] = "Metals-Products sold <span>(@)</span>";
					$label[3] = "Closing stocks of Metals-Products";
					$label[4] = "Metal-Product";
					$label[5] = "Quantity";
					$label[6] = "Grade";
					$label[7] = "Value<span>(#)</span> (₹)";
					$label['btn'] = "Add more";
					$label['note_txt'] = "Note:";
					$label['note_1'] = "(#) Please give ex-plant sale value.";
					$label['note_2'] = "(@) Please give category-wise break-up of metals and other products sold.";
				}
			}
			
			// Part II: Production and Stocks of ROM for FORM 3
			if($form_name == 'rom_stocks_three') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "1. आरओएम उत्पादन";
					$label[0] = "प्रवर्ग";
					$label[1] = "मात्रा";
					$label[2] = "(क) विवृत खनिज";
					$label[3] = "(ख) भूमिगत खनिज";
					$label[4] = "खनिज";
					$label[5] = "वित्तीय वर्ष के लिए उत्पादन प्रस्ताव";
					$label[6] = "वित्तीय वर्ष के दौरान रिपोर्ट किया गया उत्पादन";
					$label[7] = "चालू वित्तीय वर्ष के लिए उत्पादन प्रस्ताव";
					$label[8] = "चालू माह तक रिपोर्ट के अनुसार संचयी उत्पादन";
					$label[9] = "अंतर";
					$label[10] = "मात्रा की इकाई";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "1. ROM Production";
					$label[0] = "Category";
					$label[1] = "Quantity";
					$label[2] = "(a) Opencast workings";
					$label[3] = "(b) Underground workings";
					$label[4] = "Mineral";
					$label[5] = "Production proposal for financial year";
					$label[6] = "Production reported during the financial year";
					$label[7] = "Production proposal for current financial year";
					$label[8] = "Cumulative production as reported upto the current month";
					$label[9] = "Difference";
					$label[10] = "Unit of quantity";

				}
			}
			
			// Part II: Production, Stocks and Dispatches (FORM F3)
			if($form_name == 'prod_stock_dis') {
				if ($lan == 'hindi') {
					
					$part_no = ($return_type == 'MONTHLY') ? "2" : "5";
					$label['rule'] = "नियम 45(5)(".$rule_sec['hn'].") (".$rule_no.") देखें";
					$label['part'] = "भाग-".$part_no." (उत्पादन, प्रेषण और स्टॉक)";
					$label['title'] = "2. उत्पादन, स्टॉक और प्रेषण";
					$label[0] = "रत्न का प्रकार";
					$label[1] = "औद्योगिक";
					$label[2] = "अन्य";
					$label[3] = "अपरिष्कृत और अनकट रत्न";
					$label[4] = "कर्तन और परिस्कृत किए गए रत्न";
					$label[5] = "रत्नों की सं.";
					$label[6] = "मात्रा @";
					$label[7] = "क. प्रारंभिक स्टॉक";
					$label[8] = "ख. उत्पादन";
					$label[9] = "(i) विवृत खनिज से";
					$label[10] = "(ii) भूमिगत खनिज से";
					$label[11] = "कुल (उत्पादन)";
					$label[12] = "ग. प्रेषण";
					$label[13] = "घ. अंतिम स्टॉक";
					$label[14] = "ड़. खान पर मूल्य(रु.)";
					$label[15] = "@ मात्रा की इकाई यथा-केरेटस /ग्राम/किग्रा आदि, यथा प्रयुक्त, मात्रा के निचे उपदर्शित किया जाए |";
					
				} else {
					
					$part_no = ($return_type == 'MONTHLY') ? "II" : "VI";
					$label['rule'] = "See rule 45(5)(".$rule_sec['en'].") (".$rule_no.")";
					$label['part'] = "PART-".$part_no." (PRODUCTION, DESPATCHES AND STOCKS)";
					$label['title'] = "2. Production, stocks and dispatches:-";
					$label[0] = "Gem Variety";
					$label[1] = "Industrial";
					$label[2] = "Others";
					$label[3] = "Rough and uncut stones";
					$label[4] = "Cut and Polished Stones";
					$label[5] = "No. of stones";
					$label[6] = "Qty @";
					$label[7] = "A. Opening Stock";
					$label[8] = "B. Production";
					$label[9] = "(i) From Opencast Working";
					$label[10] = "(ii) From Underground Working";
					$label[11] = "TOTAL (production)";
					$label[12] = "C. Despatches";
					$label[13] = "D. Closing Stocks";
					$label[14] = "E. Ex-mine Price (₹)";
					//commented for F3 - Part 2.2
					//$label[15] = "*This should be estimated for all the stones produced during the month whether sold or not on the basis of average sale price obtained for sales made during the month. In case no sales are made Ex-pit-head, the ex-mine price should be arrived at after deducting the actual expenses incurred from the pit-head to the point of sale, from the sale price realised.";
					$label[15] = "@:The Unit of quantity viz. Carats-Grams-Kilogram etc., as the case may be,should be indicated under quantity.";

				}
			}

			// PART L / PART M
			// Part I: INSTRUCTION
			if($form_name == 'instruction') {
				if ($lan == 'hindi') {

					$ruleNo = ($return_type == 'MONTHLY') ? 'क' : 'ख';
					
					$label['rule'] = "नियम 45(6)(".$ruleNo.") देखें";
					$label['part'] = "महत्वपूर्ण अनुदेश";
					$label['title'] = "प्ररूप भरने के लिए महत्वपूर्ण अनुदेश";
					$label[0] = ($return_type == 'MONTHLY') ? "यह प्रपत्र, सम्यक भर कर, हर महीने के दसवें दिन पिछले महीने के संबंध में, ऑनलाइन के माध्यम से नियम में निर्धारित संबंधित प्राधिकारियों तक पहुँच जाना चाहिए |" : "यह प्ररूप, प्रत्येक वर्ष की जुलाई के पहले दिन पूर्ववर्ती वित्तीय वर्ष के लिए सम्यक भर कर ऑनलाइन के माध्यम से, नियम में निर्धारित संबंधित प्राधिकारियों तक पहुँच जाना चाहिए|";
					$label[1] = "इसे खनिज सरंक्षण विकास नियम, 2017 के नियम 66 के अंतर्गत, समय-समय पर महानियंत्रक भारतीय खान ब्यूरो द्वारा अधिसूचित क्षेत्रीय नियंत्रक को भेजा जाना चाहिए, जिसके क्षेत्राधिकार में खनिज रियायत पड़ती है|";
					$label[2] = "प्ररूप पर संबंधित व्यक्ति के आंगुलिक हस्ताक्षर होने चाहिए|";
					$label[3] = "परिमाण टन में दर्ज करें | अगर ऐसा नहीं है तो इकाई निर्दिष्ट करें|";
					$label[4] = "मूल्य सिर्फ रुपये में दर्ज किया जाए|";
					$label[5] = "रजिस्ट्रीकरण संख्या का मतलब भारतीय खान ब्यूरो द्वारा पट्टा धारक - मालिक या व्यापारी - स्टॉकिस्ट - अंतिम उपयोगकर्ता- खनिज आधारित उद्योग - निर्यातक को आवंटित रजिस्ट्रीकरण संख्या से है|";
					$label[6] = "रिपोर्ट करते समय विभित्र खनिजों के लिए प्रपत्र में दी गई, अयस्क श्रेणी, का सख्ती से इस्तेमाल किया जायेगा|";
					$label[7] = "मद 5 में दी गयी कच्चे मॉल की खपत को सभी अंतिम उपयोग से संबंधित उद्योग और लोह और इस्पात उद्योग द्वारा भरा जा सकता है|";
					
				} else {

					$ruleNo = ($return_type == 'MONTHLY') ? 'a' : 'b';
					
					$label['rule'] = "See rule 45(6)(".$ruleNo.")";
					$label['part'] = "INSTRUCTION";
					$label['title'] = "IMPORTANT INSTRUCTIONS FOR FILLING THE FORM";
					$label[0] = ($return_type == 'MONTHLY') ? "This Form, duly filled in must reach the concerned authorities as prescribed within the rule, before the tenth day of every month in respect of the preceding month, through online." : "This Form, duly filled in must reach the concerned authorities as prescribed within the rule, before the first day of July of each year for the preceding financial year, through online.";
					$label[1] = "This should be sent to the Regional Controller in whose territorial jurisdiction the mineral concession falls as notified from time to time by the Controller General, Indian Bureau of Mines, under rule 66 of the Mineral Conservation Development Rules, 2017.";
					$label[2] = "The form should be digitally signed by the concerned person.";
					$label[3] = "Quantity to be reported in tonnes. If not please specify the unit.";
					$label[4] = "Value to be reported in rupees only.";
					$label[5] = "Registration number means the registration number allotted by Indian Bureau of Mines to the lessee-owner or to a trader- stockist - end-use mineral based industry - exporter.";
					$label[6] = "Ore grade for various minerals, as given in the form, to be strictly used while reporting.";
					$label[7] = "Item 5 related to raw materials consumed may be filled up by all end use industry and iron and steel industry also";

				}
			}
			
			// Part I: GENERAL PARTICULAR
			if($form_name == 'general_particular') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(क) देखें";
					$label['part'] = "1. साधारण विशिष्टियां";
					$label['next_part'] = "2. माह में की गई गतिविधि के विवरण पर विवरण ";
					$label[0] = "रजिस्ट्रीकरण संख्या (भारतीय खान ब्यूरो द्वारा आबंटित)";
					$label[1] = "नाम और पता";
					$label[2] = "संयंत्र का नाम-भंडारण अवस्थिति, यदि उपलब्ध";
					$label[3] = "देशांश और अक्षांश";
					$label[4] = "रिपोर्ट की किए गए क्रियाकलाप (पों) का नाम";
					$label[5] = "(जो भी लागु हों उन पर सही चिन्ह लगाए)";
					$label[6] = "(क)";
					$label[7] = "(ख)";
					$label[8] = "(ग)";
					$label[9] = "(घ)";
					$label[10] = "कारबार";
					$label[11] = "निर्यात";
					$label[12] = "अंतः उपयोग";
					$label[13] = "भंडारण";
					
				} else {
					
					$label['rule'] = "See rule 45(6)(a)";
					$label['part'] = "1. GENERAL PARTICULARS";
					$label['next_part'] = "2. STATEMENT ON DETAILS OF THE ACTIVITY UNDERTAKEN IN THE MONTH OF ";
					$label[0] = "Registration No ( allotted by IBM)";
					$label[1] = "Name and Address";
					$label[2] = "Plant Name-Storage location, if available";
					$label[3] = "Latitude and Longitude";
					$label[4] = "Name of activity(s) reported";
					$label[5] = "(Tick whichever is-are applicable)";
					$label[6] = "(a)";
					$label[7] = "(b)";
					$label[8] = "(c)";
					$label[9] = "(d)";
					$label[10] = "Trading";
					$label[11] = "Export";
					$label[12] = "End-use";
					$label[13] = "Storage";

				}
			}
			
			// Part II: TRADING ACTIVITY
			if($form_name == 'trading_activity') {
				if ($lan == 'hindi') {

					$label['rule'] = "नियम 45(6)(क) देखें";
					$label['part'] = "2. क्रिया कलापों के विवरण";
					$label['title'] = "(क) व्यापारिक क्रियाकलाप";
					$label['title_next'] = "(क) व्यापारिक क्रियाकलाप कायम है...";
					$label[0] = "खनिज - अयस्क";
					$label[1] = "श्रेणीवार खनिज - अयस्क #";
					$label[2] = "प्रारंभिक स्टॉक";
					$label[3] = "मास के दौरान ख़रीदा गया अयस्क (देश के अंदर)";
					$label[4] = "मास के दौरान आयात किया गया अयस्क";
					$label[5] = "मास के दौरान परेशान किया गया अयस्क";
					$label[6] = "अंतिम शेष भंडार";
					$label[7] = "मात्रा";
					$label[8] = "भारतीय खान ब्यूरो द्वारा प्रदायक को आवंटित रजिस्ट्रीकरण संख्या (अगर एक से ज्यादा प्रदायक हो तो पृथक रूप से लिखे)";
					$label[9] = "मूल्य (रु.में)";
					$label[10] = "देश";
					$label[11] = "भारतीय खान ब्यूरो द्वारा क्रेता को आवंटित रजिस्ट्री करण संख्या (अगर एक से ज्यादा क्रेता हो तो पृथक रूप से लिखे)";
					$label[13] = "Remark";
					$label['btn'] = "अधिक जोड़ें";
					$label['btn_1'] = "अधिक जोड़ें (खनिज)";
					$label['btn_2'] = "अधिक जोड़ें (श्रेणीवार)";
					$label['btn_3'] = "अधिक जोड़ें (प्रदायक)";
					$label['btn_4'] = "अधिक जोड़ें (क्रेता)";
					
				} else {

					$returnTypeSm = ($return_type == 'MONTHLY') ? 'month' : 'year';
					
					$label['rule'] = "See rule 45(6)(a)";
					$label['part'] = "2. DETAILS OF THE ACTIVITY";
					$label['title'] = "(a) Trading Activity";
					$label['title_next'] = "(a) Trading Activity continues...";
					$label[0] = "Mineral-Ore";
					$label[1] = "Grade of mineral ore #";
					$label[2] = "Opening stock";
					$label[3] = "Ore purchased during the ".$returnTypeSm."<br>(within the country)";
					$label[4] = "Ore imported during the ".$returnTypeSm;
					$label[5] = "Ore dispatched during the ".$returnTypeSm;
					$label[6] = "Closing stock";
					$label[7] = "Quantity";
					$label[8] = "Registration number as allotted by the Indian Bureau of Mines to the supplier <br>(to indicate separately if more than one supplier)";
					$label[9] = "Value (in <i class='fa fa-rupee-sign'></i>)";
					$label[10] = "Country";
					$label[11] = "Registration number as allotted by the Indian Bureau of Mines to the buyer <br>(to indicate separately if more than one buyer)";
					$label[13] = "Remark";
					$label['btn'] = "Add more";
					$label['btn_1'] = "Add more (Mineral)";
					$label['btn_2'] = "Add more (Grade)";
					$label['btn_3'] = "Add more (Supplier)";
					$label['btn_4'] = "Add more (Buyer)";

				}
			}
			
			// Part II: EXPORT ACTIVITY
			if($form_name == 'export_of_ore') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(क) देखें";
					$label['part'] = "2. क्रिया कलापों के विवरण";
					$label['title'] = "(ख) अयस्क का निर्यात";
					$label['title_next'] = "(ख) अयस्क का निर्यात कायम है...";
					$label[0] = "खनिज - अयस्क";
					$label[1] = "श्रेणीवार खनिज - अयस्क #";
					$label[2] = "प्रारंभिक स्टॉक";
					$label[3] = "मास के दौरान ख़रीदा गया अयस्क (देश के अंदर)";
					$label[4] = "मास के दौरान आयात किया गया अयस्क";
					$label[5] = "मास के दौरान निर्यात किया गया अयस्क";
					$label[6] = "अंतिम शेष भंडार";
					$label[7] = "मात्रा";
					$label[8] = "भारतीय खान ब्यूरो द्वारा प्रदायक को आवंटित रजिस्ट्रीकरण संख्या (अगर एक से ज्यादा प्रदायक हो तो पृथक रूप से लिखे)";
					$label[9] = "मूल्य (रु.में)";
					$label[10] = "देश";
					$label[11] = "भारतीय खान ब्यूरो द्वारा क्रेता को आवंटित रजिस्ट्री करण संख्या (अगर एक से ज्यादा क्रेता हो तो पृथक रूप से लिखे)";
					$label[13] = "Remark";
					$label['btn'] = "अधिक जोड़ें";
					$label['btn_1'] = "अधिक जोड़ें (खनिज)";
					$label['btn_2'] = "अधिक जोड़ें (श्रेणीवार)";
					$label['btn_3'] = "अधिक जोड़ें (प्रदायक)";
					$label['btn_4'] = "अधिक जोड़ें (क्रेता)";
					
				} else {
					
					$returnTypeSm = ($return_type == 'MONTHLY') ? 'month' : 'year';

					$label['rule'] = "See rule 45(6)(a)";
					$label['part'] = "2. DETAILS OF THE ACTIVITY";
					$label['title'] = "(b) Export of ore";
					$label['title_next'] = "(b) Export of ore continues...";
					$label[0] = "Mineral-Ore";
					$label[1] = "Grade of mineral ore #";
					$label[2] = "Opening stock";
					$label[3] = "Ore procured during the ".$returnTypeSm." for export<br>(from within the country)";
					$label[4] = "Ore imported during the ".$returnTypeSm;
					$label[5] = "Ore exported during the ".$returnTypeSm;
					$label[6] = "Closing stock";
					$label[7] = "Quantity";
					$label[8] = "Registration number as allotted by the Indian Bureau of Mines to the supplier <br>(to indicate separately if more than one supplier)";
					$label[9] = "Value (in <i class='fa fa-rupee-sign'></i>)";
					$label[10] = "Country";
					$label[11] = "Registration number as allotted by the Indian Bureau of Mines to the buyer <br>(to indicate separately if more than one buyer)";
					$label[13] = "Remark";
					$label['btn'] = "Add more";
					$label['btn_1'] = "Add more (Mineral)";
					$label['btn_2'] = "Add more (Grade)";
					$label['btn_3'] = "Add more (Supplier)";
					$label['btn_4'] = "Add more (Buyer)";

				}
			}
			
			// Part II: END-USE MINERAL BASED ACTIVITY
			if($form_name == 'mineral_base_activity') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(क) देखें";
					$label['part'] = "2. क्रिया कलापों के विवरण";
					$label['title'] = "(ग) अंतः उपयोग खनिज आधारित क्रियाकलाप";
					$label['title_next'] = "(ग) अंतः उपयोग खनिज आधारित क्रियाकलाप कायम है...";
					$label[0] = "खनिज - अयस्क";
					$label[1] = "श्रेणीवार खनिज - अयस्क #";
					$label[2] = "प्रारंभिक स्टॉक";
					$label[3] = "मास के दौरान उपारित गया अयस्क (देश के अंदर)";
					$label[4] = "मास के दौरान आयात किया गया अयस्क";
					$label[5] = "मास के दौरान उपभोग किया गया अयस्क";
					$label[6] = "अंतिम शेष भंडार";
					$label[7] = "मात्रा";
					$label[8] = "भारतीय खान ब्यूरो द्वारा प्रदायक को आवंटित रजिस्ट्रीकरण संख्या (अगर एक से ज्यादा प्रदायक हो तो पृथक रूप से लिखे)";
					$label[9] = "मूल्य (रु.में)";
					$label[10] = "देश";
					$label[11] = "भारतीय खान ब्यूरो द्वारा क्रेता को आवंटित संख्या के रूप में रजिस्ट्रीकरण (अगर एक से ज्यादा क्रेता हो तो पृथक रूप से लिखे)";
					$label[12] = "मास के दौरान प्रेषण किया गया अयस्क";
					$label[13] = "Remark";
					$label['btn'] = "अधिक जोड़ें";
					$label['btn_1'] = "अधिक जोड़ें (खनिज)";
					$label['btn_2'] = "अधिक जोड़ें (श्रेणीवार)";
					$label['btn_3'] = "अधिक जोड़ें (प्रदायक)";
					$label['btn_4'] = "अधिक जोड़ें (क्रेता)";
					
				} else {
					
					$returnTypeSm = ($return_type == 'MONTHLY') ? 'month' : 'year';

					$label['rule'] = "See rule 45(6)(a)";
					$label['part'] = "2. DETAILS OF THE ACTIVITY";
					$label['title'] = "(c) End-use mineral based activity";
					$label['title_next'] = "(c) End-use mineral based activity continues...";
					$label[0] = "Mineral-Ore";
					$label[1] = "Grade of mineral- ore #";
					$label[2] = "Opening stock";
					$label[3] = "Ore procured during the ".$returnTypeSm." (within the country)";
					$label[4] = "Ore imported during the ".$returnTypeSm;
					$label[5] = "Ore dispatched during the ".$returnTypeSm;
					$label[6] = "Closing stock";
					$label[7] = "Quantity";
					$label[8] = "Registration number as allotted by the Indian Bureau of Mines to the supplier <br>(to indicate separately if more than one supplier)";
					$label[9] = "Value (in <i class='fa fa-rupee-sign'></i>)";
					$label[10] = "Country";
					$label[11] = "Registration number as allotted by the Indian Bureau of Mines to the buyer <br>(to indicate separately if more than one buyer)";
					$label[12] = "Ore consumed during the ".$returnTypeSm;
					$label[13] = "Remark";
					$label['btn'] = "Add more";
					$label['btn_1'] = "Add more (Mineral)";
					$label['btn_2'] = "Add more (Grade)";
					$label['btn_3'] = "Add more (Supplier)";
					$label['btn_4'] = "Add more (Buyer)";

				}
			}
			
			// Part II: STORAGE ACTIVITY
			if($form_name == 'storage_activity') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(क) देखें";
					$label['part'] = "2. क्रिया कलापों के विवरण";
					$label['title'] = "(घ) भंडारण क्रियाकलाप";
					$label['title_next'] = "(घ) भंडारण क्रियाकलाप कायम है...";
					$label[0] = "खनिज - अयस्क";
					$label[1] = "श्रेणीवार खनिज - अयस्क #";
					$label[2] = "प्रारंभिक स्टॉक";
					$label[3] = "मास के दौरान ख़रीदा गया अयस्क (देश के अंदर)";
					$label[4] = "मास के दौरान आयात किया गया अयस्क";
					$label[5] = "मास के दौरान प्रेषण किया गया अयस्क";
					$label[6] = "अंतिम शेष भंडार";
					$label[7] = "मात्रा";
					$label[8] = "भारतीय खान ब्यूरो द्वारा प्रदायक को आवंटित रजिस्ट्रीकरण संख्या (अगर एक से ज्यादा प्रदायक हो तो पृथक रूप से लिखे)";
					$label[9] = "मूल्य (रु.में)";
					$label[10] = "देश";
					$label[11] = "भारतीय खान ब्यूरो द्वारा व्यक्ति-कंपनी जिन्हे अयस्क निपटान किया गया हो को आबंटित संख्या (अगर एक से ज्यादा व्यक्ति-कंपनी हो तो पृथक रूप से लिखें)";
					$label[13] = "Remark";
					$label['btn'] = "अधिक जोड़ें";
					$label['btn_1'] = "अधिक जोड़ें (खनिज)";
					$label['btn_2'] = "अधिक जोड़ें (श्रेणीवार)";
					$label['btn_3'] = "अधिक जोड़ें (प्रदायक)";
					$label['btn_4'] = "अधिक जोड़ें (क्रेता)";
					
				} else {
					
					$returnTypeSm = ($return_type == 'MONTHLY') ? 'month' : 'year';

					$label['rule'] = "See rule 45(6)(a)";
					$label['part'] = "2. DETAILS OF THE ACTIVITY";
					$label['title'] = "(d) Storage Activity";
					$label['title_next'] = "(d) Storage Activity continues...";
					$label[0] = "Mineral-Ore";
					$label[1] = "Grade of mineral ore #";
					$label[2] = "Opening stock";
					$label[3] = "Ore received during the ".$returnTypeSm."<br>(within the country)";
					$label[4] = "Ore imported during the ".$returnTypeSm;
					$label[5] = "Ore dispatched during the ".$returnTypeSm;
					$label[6] = "Closing stock";
					$label[7] = "Quantity";
					$label[8] = "Registration number as allotted by the Indian Bureau of Mines to the supplier <br>(to indicate separately if more than one supplier)";
					$label[9] = "Value (in <i class='fa fa-rupee-sign'></i>)";
					$label[10] = "Country";
					$label[11] = "Registration number as allotted by the Indian Bureau of Mines to the person-company to whom ore dispatched<br>(to indicate separately if more than one person-company)";
					$label[13] = "Remark";
					$label['btn'] = "Add more";
					$label['btn_1'] = "Add more (Mineral)";
					$label['btn_2'] = "Add more (Grade)";
					$label['btn_3'] = "Add more (Supplier)";
					$label['btn_4'] = "Add more (Buyer)";

				}
			}

			// ANNUAL RETURN
			// PART I: PARTICULARS OF AREA OPERATED
			if($form_name == 'particulars') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-1 (साधारण)";
					$label['title'] = "11. प्रचलित क्षेत्र-पट्टे की विशिष्टियां";
					$label['title_note'] = "(खनन कार्य एक से अधिक खानों में होने की स्थिति में सूचनाएं (i) से (vi) पर दें)";
					$label[0] = "(i) राज्य सरकार द्वारा आबंटित पट्टाधारक संख्या";
					$label[1] = "(ii) पट्टाधाराकयुक्त क्षेत्र (हेक्टेयर)";
					$label[2] = "वन अंतर्गत क्षेत्र";
					$label[3] = "वनरहित क्षेत्र";
					$label[4] = "कुल";
					$label[5] = "(iii) खनन पट्टाधारक विलेष निष्पादन की तारीख";
					$label[6] = "(iv) पट्टाधारक अवधि";
					$label[7] = "(v) सतही अधिकार प्राप्त क्षेत्र (हेक्टेयर)";
					$label[8] = "(vi) (a) नवीनीकरण की तारीख (यदि लागू हो)";
					$label['8-1'] = "(vi) Date and period of renewal (if applicable)";
					$label[9] = "(vi) (b) नवीनीकरण की अवधि (यदि लागू हो)";
					$label[10] = "(vii) पत्ता क्षेत्र, वर्ष के अंत में उपयोग किया गया (सतही क्षेत्र) (हेक्टेयर)";
					$label[11] = "Mine Name";
					$label[12] = "Mine Code";
					$label[13] = "Mineral Name";
					$label['btn'] = "अधिक जोड़ें पट्टाधारक";
					$label['unit'] = "हेक्टेयर";
					$label['note'] = '<span class="text-danger">टिप: </span>बहुविकल्पी चयन के लिए , <kbd class="bg-secondary">Ctrl</kbd> दबाएं और चुनें';
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-I (General)";
					$label['title'] = "11. Particulars of area operated-Lease";
					$label['title_note'] = "(Furnish information on items (i) to (vi) lease-wise in case mine workings cover more than one lease)";
					$label[0] = "(i) Lease number allotted by the State Government";
					$label[1] = "(ii) Area under lease (hectares):";
					$label[2] = "Under Forest";
					$label[3] = "Outside Forest";
					$label[4] = "Total";
					$label[5] = "(iii) Date of execution of mining lease deed";
					$label[6] = "(iv) Period of lease";
					$label[7] = "(v) Area for which surface rights are held (hectares)";
					$label[8] = "(vi) (a) Date of renewal (if applicable)";
					$label['8-1'] = "(vi) Date and period of renewal (if applicable)";
					$label[9] = "(vi) (b) Period of renewal (if applicable)";
					$label[10] = "(vii) In case there is more than one mine in the same lease area, indicate name of mine and mineral produced";
					$label[11] = "Mine Name";
					$label[12] = "Mine Code";
					$label[13] = "Mineral Name";
					$label['btn'] = "Add More Lease";
					$label['unit'] = "hectares";
					$label['note'] = '<span class="text-danger">Tip: </span>For multiple selection , Press <kbd class="bg-secondary">Ctrl</kbd> and select';

				}
			}
			
			// PART I: LEASE AREA UTILISATION
			if($form_name == 'area_utilisation') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-1 (साधारण)";
					$label['title'] = "12. पट्टा क्षेत्र, वर्ष के अंत में उपयोग किया गया (सतही क्षेत्र) (हेक्टेयर):";
					$label[0] = "वन अंतर्गत";
					$label[1] = "वन रहित";
					$label[2] = "कुल";
					$label[3] = "(i) पूर्व दोहन एवं विवृत (ओ-सी) खनन द्वारा परित्यक्त क्षेत्र";
					$label[4] = "(ii) चालू (ओ-सी) कार्यांतर्गत";
					$label[5] = "(iii) उध्दार-पुनर्वासित";
					$label[6] = "(iv) अपशिष्ट निस्तारण के लिए प्रयुक्त";
					$label[7] = "(v) पौधों, भवनों, रिहायशी क्षेत्र, कल्याण भवनों और मार्गों द्वारा अधिमांगी";
					$label[8] = "(vi) किसी अन्य प्रयोजन के लिए प्रयुक्त (विशेष विनिर्दिष्ट करें)";
					$label[9] = "(vii) वर्ष के दौरान सतत खान बंदी प्रगति के अधीन किया गया कार्य";
					$label[10] = "13. स्वामित्व -खान की दोहन अभिकरण: (पब्लिक सेक्टर-प्राइवेट सेक्टर-संयुक्त सेक्टर):";
					$label[11] = "(Public Sector-Private Sector-Joint Sector)";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-I (General)";
					$label['title'] = "12. Lease area (surface area) utilisation as at the end of year (hectares):";
					$label[0] = "Under forest";
					$label[1] = "Outside forest";
					$label[2] = "Total";
					$label[3] = "(i) Already exploited and abandoned by opencast (O-C) mining";
					$label[4] = "(ii) Covered under current (O-C) Workings";
					$label[5] = "(iii) Reclaimed-rehabilitated";
					$label[6] = "(iv) Used for waste disposal";
					$label[7] = "(v) Occupied by plant, buildings, residential, welfare buildings and roads";
					$label[8] = "(vi) Used for any other purpose (specify)";
					$label[9] = "(vii) Work done under progressive mine closure plan during the year";
					$label[10] = "13. Ownership-exploiting Agency of the mine:";
					$label[11] = "(Public Sector-Private Sector-Joint Sector)";

				}
			}
			
			// PART IV: CONSUMPTION OF EXPLOSIVES
			if($form_name == 'explosive_consumption') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-4 (विस्फोटकों की खपत)";
					$label['title'] = "विस्फोटकों की खपत";
					$label[0] = "मैग्जीन की अनुज्ञापित क्षमता: (किलोग्राम-टन-संख्या -मीटर का अलग से विनिर्दिष्ट करें)";
					$label[1] = "मद";
					$label[2] = "इकाई";
					$label[3] = "क्षमता";
					$label[4] = "विस्फोटक";
					$label[5] = "डेटोनेटर";
					$label[6] = "फ्यूज";
					$label[7] = "कि ग्राम.";
					$label[8] = "संख्या";
					$label[9] = "मीटर";
					$label[10] = "विस्फोटकों का वर्गीकरण";
					$label[11] = "वर्ष के दौरान उपभुक्त मात्रा";
					$label[12] = "अगले वर्ष के लिए प्रक्कलित अपेक्षा";
					$label[13] = "लघु डायमीटर (32 यमयम तक)";
					$label[14] = "बडा डायमीटर (32 यमयम के ऊपर)";
					$label[15] = "1. गन पाउडर";
					$label[16] = "2. नाइट्रेट मिश्रण";
					$label[17] = "क. लूज अमोनियम नाइट्रेट";
					$label[18] = "ख. कार्टेजज रूप में अमोनियम नाइट्रेट";
					$label[19] = "3. नाइट्रो कंपाउंड";
					$label[20] = "4. तरल ऑक्सीजन सॉक्ड कार्टेजज";
					$label[21] = "5. पतला विस्फोटक (विभिन्न व्यापारों का नाम दे)";
					$label[22] = "6. डेटोनेटर";
					$label[23] = "i) साधारण";
					$label[24] = "ii) विद्युतीय";
					$label[25] = "(a) साधारण";
					$label[26] = "(b) विलंब";
					$label[27] = "7. फ्यूज";
					$label[28] = "(a) सुरजा फ्यूज";
					$label[29] = "(b) डेटोनेटिंग फ्यूज";
					$label[30] = "8. प्लास्टिक इग्नीशन कार्ड";
					$label[31] = "9. अन्य (विनिर्दिष्ट करें)";
					$label[32] = "निर्माता के अनुदेश के अनुसार कि.ग्राम के समकक्ष भिगाया गया तरल ऑक्सीजल कट्रीज के विभिन्न आकार";
					$label['other_unit'] = [''=>'-इकाई चुनिए-', 'Kg'=>' कि ग्राम. ', 'Nos.'=>' संख्या ', 'Meters'=>' मीटर '];
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-IV (Consumption of Explosives)";
					$label['title'] = "Consumption of Explosives";
					$label[0] = "Licensed capacity of magazine: (specify unit separately in kg-tonne, numbers, metres )";
					$label[1] = "Item";
					$label[2] = "Unit";
					$label[3] = "Capacity";
					$label[4] = "Explosives";
					$label[5] = "Detonators";
					$label[6] = "Fuses";
					$label[7] = "Kg.";
					$label[8] = "No.s";
					$label[9] = "Mts";
					$label[10] = "Classification of Explosives";
					$label[11] = "Quantity consumed during the year";
					$label[12] = "Estimated requirement during the next year";
					$label[13] = "Small dia.<br>(upto 32 mm)";
					$label[14] = "Large dia.<br>(above 32 mm)";
					$label[15] = "1. Gun Powder";
					$label[16] = "2. Nitrate Mixture ";
					$label[17] = "a. Loose ammonium nitrate";
					$label[18] = "b. Ammonium nitrate in cartridged form";
					$label[19] = "3. Nitro compound";
					$label[20] = "4. Liquid Oxygen soaked cartridges";
					$label[21] = "5. Slurry explosives (Mention different trade names)";
					$label[22] = "6. Detonators";
					$label[23] = "i) Ordinary";
					$label[24] = "ii) Electrical";
					$label[25] = "(a) Ordinary";
					$label[26] = "(b) Delay";
					$label[27] = "7. Fuse";
					$label[28] = "(a) Safety Fuse";
					$label[29] = "(b) Detonating Fuse";
					$label[30] = "8. Plastic ignition cord";
					$label[31] = "9. Others (specify)";
					$label[32] = "Different sizes of soaked liquid oxygen cartridges to be reported in equivalent kg. as per manufacturer’s instruction.";
					$label['other_unit'] = [''=>'-Select Unit-', 'Kg'=>' Kg ', 'Nos.'=>' Nos. ', 'Meters'=>' Meters '];

				}
			}
			
			// PART V: SEC 1: 1. EXPLORATION
			if($form_name == 'geology_exploration') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "PART-V (साधारण भूविज्ञान और खनन) ";
					$label['part-sub'] = "(मद 2 व 3 को प्रत्येक खनिज  के  लिए अलग - अलग प्रस्तुत किया जाए )";
					$label['title'] = "1. गवेषणा";
					$label[0] = "1(i) वर्ष के दौरान गवेषणा गतिविधियां:";
					$label[1] = "वर्ष के आरंभ में";
					$label[2] = "वर्ष के दौरान";
					$label[3] = "संचयी";
					$label[4] = "ग्रिड अंतरण आयाम";
					$label[5] = "वेधन";
					$label[6] = "छिद्रों की संख्या";
					$label[7] = "मिट्रीज";
					$label[8] = "पिटींग";
					$label[9] = "पिट की संख्या";
					$label[10] = "उत्खनन<br>(घन मीटर<sup>3</sup> में )";
					$label[11] = "ट्रेंचिंग";
					$label[12] = "ट्रेंचों की संख्या";
					$label[13] = "उत्खनन<br>(घन मीटर<sup>3</sup> में )";
					$label[14] = "आच्छादित लम्बाई (मीटर में)";
					$label[15] = "गवेषण पर व्यय<br>(<span class='fa fa-rupee'>&#8377;</span>)";
					$label[16] = "1(ii). वर्ष के दौरान कोई अन्य गवेषण गतिविधि:";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-V (General Geology & Mining)";
					$label['part-sub'] = "(Items 2 and 3 to be submitted separately for each mineral)";
					$label['title'] = "1. Exploration";
					$label[0] = "1(i) Exploration activities during the year:";
					$label[1] = "At the beginning of the year";
					$label[2] = "During the year";
					$label[3] = "Cumulative";
					$label[4] = "Grid spacing-Dimension";
					$label[5] = "Drilling";
					$label[6] = "No of holes";
					$label[7] = "Metrage";
					$label[8] = "Pitting";
					$label[9] = "No of pits";
					$label[10] = "Excavation<br>(in m<sup>3</sup>)";
					$label[11] = "Trenching";
					$label[12] = "No of trenches";
					$label[13] = "Excavation<br>(in m<sup>3</sup>)";
					$label[14] = "Length covered<br>(in metre)";
					$label[15] = "Expenditure on exploration (<span class='fa fa-rupee'>&#8377;</span>)";
					$label[16] = "1(ii). Any other exploration activity during the year:";

				}
			}
			
			// PART V: SEC 2: 2. RESERVES AND RESOURCES ESTIMATED / 3. SUBGRADE-MINERAL REJECT
			if($form_name == 'geology_reserves_subgrade') {
				//print_r($return_date);die;
				$returnYear = date('Y',strtotime($return_date));
				$returnYearTo = date('Y',strtotime('+ 365 days',strtotime($return_date)));
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "PART-V (साधारण भूविज्ञान और खनन)";
					$label['title'] = "2. प्रक्कलित भंडार एवं संसाधन (टन में)";
					$label[0] = "वर्गीकरण";
					$label[1] = "कोड";
					$label[2] = "नवीनतम अनुमोदित खनन योजना-स्कीम के अनुसार वर्ष के आरंभ 1.4.".$returnYear." में";
					$label[3] = "वर्ष के दौरान आकलन";
					$label[4] = "वर्ष के दौरान भंडार का रिक्तिकरण";
					$label[5] = "31.3.".$returnYearTo." को शेष संसाधन";
					$label[6] = "क. आरक्षित खनिज भंडार";
					$label[7] = "1. सबूत प्राप्त खनिज भंडार";
					$label[8] = "2. संभावित खनिज भंडार";
					$label[9] = "3. कुल आरक्षित";
					$label[10] = "ख. शेष संसाधन";
					$label[11] = "1. साध्यता खनिज संसाधन";
					$label[12] = "2. व्यवहार्यता पूर्व खनिज संसाधन";
					$label[13] = "3. मापित खनिज संसाधन";
					$label[14] = "4. इंगित खनिज संसाधन";
					$label[15] = "5. प्रक्कलित खनिज संसाधन";
					$label[16] = "6. आवीक्षण खनिज संसाधन";
					$label[17] = "7. कुल शेष संसाधन";
					$label[18] = "कुल (क +ख)";
					$label['title_two'] = "3. उन्नयन-परित्यक्त खनिज (टन में)";
					$label[19] = "( कट-ऑफ श्रेणी से कम और थ्रेश होल्ड मूल्य से अधिक यदि निर्धारित किया गया हो, विद्यमान बिक्री मूल्य रहित उत्पन्न और राशिकृत-एकत्रित खनिज खंडों के संबंध में सूचना दी जाए )";
					$label[20] = "उन्नयन-परित्यक्त खनिज का प्रचालन (टन में)";
					$label[21] = "वर्ष के आरंभ मंं";
					$label[22] = "वर्ष के दौरान सृजन";
					$label[23] = "वर्ष के दौरान निस्तारण";
					$label[24] = "वर्ष के दौरान कार्य क्षमता";
					$label[25] = "सृजित अस्वीकार किए गए खनिज की औसत श्रेणी";
					$label[26] = "असंसाधित अयस्क से";
					$label[27] = "संसाधित अयस्क से";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-V (General Geology & Mining)";
					$label['title'] = "2. Reserves and Resources estimated (in tonnes)";
					$label[0] = "Classification";
					$label[1] = "Code";
					$label[2] = "At the beginning of the year 1.4.".$returnYear." as per latest approved mining plan- scheme";
					$label[3] = "Assessed during the year";
					$label[4] = "Depletion of reserves during the year";
					$label[5] = "Balance resources as on 31.3.".$returnYearTo;
					$label[6] = "<b>A. Mineral Reserve</b>";
					$label[7] = "1. Proved Mineral Reserve";
					$label[8] = "2. Probable mineral Reserve";
					$label[9] = "3. Total Reserves";
					$label[10] = "<b>B. Remaining Resources</b>";
					$label[11] = "1. Feasibility mineral Resource";
					$label[12] = "2. Prefeasibility mineral resource";
					$label[13] = "3. Measured mineral resource";
					$label[14] = "4. Indicated mineral resource";
					$label[15] = "5. Inferred mineral resource";
					$label[16] = "6. Reconnaissance mineral resource";
					$label[17] = "7. Total remaining Resources";
					$label[18] = "<b>Total (A+B)</b>";
					$label['title_two'] = "3. Subgrade-Mineral Reject (in tonnes)";
					$label[19] = "(Information to be given in respect of mineral fractions generated and stacked- dumped below cut-off grade and above threshold value, if prescribed, having no immediate sale value)";
					$label[20] = "Generation of subgrade-mineral reject (in tones)";
					$label[21] = "At the beginning of the year";
					$label[22] = "Generated during the year";
					$label[23] = "Disposed during the year";
					$label[24] = "Total stacked at the end of the year";
					$label[25] = "Average grade of the mineral reject generated";
					$label[26] = "from unprocessed ore";
					$label[27] = "from processed ore";

				}
			}

			
			// PART V: SEC 4/5: 4. OVERBURDEN AND WASTE / 5. TREES PLANTED- SURVIVAL RATE
			if($form_name == 'geology_overburden_trees') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "PART-V (साधारण भूविज्ञान और खनन)";
					$label['title'] = "4. अति भारित और अपशिष्ट (मी<sup>3</sup>)";
					$label[0] = "(थ्रेश होल्ड मूल्य यदि निहित किया गया है, से कम उपरिभारित-परिशिष्ट और उत्पन्न खनन खंडों के संबंध में सूचना दी जाएं)";
					$label[1] = "वर्ष के आरंभ में";
					$label[2] = "वर्ष के दौरान जनित";
					$label[3] = "वर्ष के दौरान निस्तारण";
					$label[4] = "वर्ष के दौरान कार्य क्षमता";
					$label[5] = "वर्ष के अंत में कुल";
					$label[6] = "5. रोपित वृ क्ष-जीवित दर";
					$label[7] = "वर्णन";
					$label[8] = "पट्टाधारक क्षेत्र के भीतर";
					$label[9] = "पट्टाधारक क्षेत्र के बाहर";
					$label[10] = "i) वर्ष के  दौरान रोपित वृक्षों की संख्या";
					$label[11] = "ii) प्रतिशत में जीवन दर";
					$label[12] = "iii) वर्ष के अंत में वृक्षों की कुल सं.";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-V (General Geology & Mining)";
					$label['title'] = "4. Overburden and Waste (in m<sup>3</sup>)";
					$label[0] = "(Information to be given in respect of overburden- waste and mineral fractions generated below threshold value, if prescribed)";
					$label[1] = "At the beginning of the year";
					$label[2] = "Generated during the year";
					$label[3] = "Disposed in dumps during the year";
					$label[4] = "Backfilled during the year";
					$label[5] = "Total at the end of the year";
					$label[6] = "5. Trees planted- survival rate";
					$label[7] = "Description";
					$label[8] = "Within lease area";
					$label[9] = "Outside lease area";
					$label[10] = "i) Number of trees planted during the year";
					$label[11] = "ii) Survival rate in percentage";
					$label[12] = "iii) Total no. of trees at the end of the year";

				}
			}
			
			// PART V: SEC 6: TYPE OF MACHINERY
			if($form_name == 'geology_part_three') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "PART-V (साधारण भूविज्ञान और खनन)";
					$label['title'] = "6. मशीनरी का प्रकार:";
					$label[0] = "उपयोग में आने वाले यथा होइस्ट, पंखे, ड्रिल, लोडर, एक्सेलेटर, डम्पर, होलेज, कन्वेयर, पम्प आदि मशीनरी के प्रकारों की निम्नलिखित सूचना दें|";
					$label[1] = "मशीनरी का प्रकार";
					$label[2] = "मशीनरी की प्रत्येक इकाई की क्षमता";
					$label[3] = "इकाई (जिसकी क्षमता ज्ञात है)";
					$label[4] = "मशीनरी की संख्या";
					$label[5] = "विद्युतीय - गैर - विद्युतीय (वर्णित करे)";
					$label[6] = "खुली भूमिगत खानों में प्रयुक्त (विनिर्दिष्ट करे)";
					$label['electric_option'] = [''=>'Select', '1'=>'Electrical', '2'=>'Non Electrical'];
					$label['opencast_option'] = [''=>'Select', '1'=>'Opencast', '2'=>'Underground', '3'=>'Both'];
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-V (General Geology & Mining)";
					$label['title'] = "6. Type of Machinery:";
					$label[0] = "Give the following information for the types of machinery in use such as hoist, fans, drills, loaders, excavators, dumpers, haulages, conveyors, pumps, etc.";
					$label[1] = "Type of machinery";
					$label[2] = "Capacity of each type of machinery";
					$label[3] = "Unit<br>(in which capacity is reported)";
					$label[4] = "No. of machinery";
					$label[5] = "Electrical Non-electrical<br>(specify)";
					$label[6] = "Used in opencast underground<br>(specify)";
					$label['electric_option'] = [''=>'Select', '1'=>'Electrical', '2'=>'Non Electrical'];
					$label['opencast_option'] = [''=>'Select', '1'=>'Opencast', '2'=>'Underground', '3'=>'Both'];

				}
			}
			
			// PART V: SEC 7: MINERAL TREATMENT PLANT
			if($form_name == 'geology_part_six') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "PART-V (साधारण भूविज्ञान और खनन)";
					$label['title'] = "7. खनिज उपचार संयंत्र";
					$label[0] = "<b>(i) खनिज उपचार संयंत्र का संक्षिप्त वर्णन यदि कोई है</b>: लगाई गई मशीनीरी की क्षमता प्रक्रिया और उसकी उपलब्धता का संक्षित विवरण दें (संयंत्र की फ्लोशीट और मैटरियल बैलेंस संलग्न करें)";
					$label[1] = "(ii) निम्नलिखित सूचना दें:";
					$label[2] = "मद";
					$label[3] = "टनेज";
					$label[4] = "औसत श्रेणी";
					$label[5] = "प्रतिपुष्टि:";
					$label[6] = "सांद्र -प्रक्रमित उत्पाद :";
					$label[7] = "(नाम लिखें)";
					$label[8] = "उप-उत्पाद-सह उत्पाद:";
					$label[9] = "पछोड़न:";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-V (General Geology & Mining)";
					$label['title'] = "7. Mineral Treatment Plant";
					$label[0] = '<b>(i) Details of mineral Treatment Plant, if any<span id="mineral"></span></b>: <span class="f_s_9">Give a brief description of the process capacity of the machinery
					deployed and its availability. (Submit Flow Sheet and Material Balance of the Plant separately).</span>';
					$label[1] = "(ii) Furnish following information:";
					$label[2] = "Item";
					$label[3] = "Tonnage";
					$label[4] = "Average Grade";
					$label[5] = "Feed:";
					$label[6] = "Concentrates-processed products :";
					$label[7] = "(mention name)";
					$label[8] = "By-products-Co-products:";
					$label[9] = "Tailings:";

				}
			}
			
			// G1 - PART VII: COST OF PRODUCTION
			if($form_name == 'production_cost') {

				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-7: उत्पादन की लागत";
					$label['title'] = "उत्पादन की लागत";
					$label[0] = "उत्पादित अयस्क - खनिज की प्रति ".$cost_unit_hn." उत्पादन लागत";
					$label[1] = "क्रम सं.";
					$label[2] = "मद";
					$label[3] = "लागत प्रति ".$cost_unit_hn." (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[4] = "प्रत्यक्ष लागत";
					$label[5] = "(क) गवेषण";
					$label[6] = "(ख) खनन";
					$label[7] = "(ग) परिस्करण (केवल यांत्रिक)";
					$label[8] = "उपरिलागत";
					$label[9] = "अवक्षयण";
					$label[10] = "ब्याज";
					$label[11] = "स्वामिस्व";
					$label[12] = "टिप";
					$label[13] = "वित्तीय वर्ष के दौरान प्रति ".$cost_unit_hn." भुगतान की गई औसत रॉयल्टी की सूचना दी जानी चाहिए";
					$label[14] = "डीएमएफ को दिया संदेय";
					$label[15] = "एनएमईटी को दिया संदेय";
					$label[16] = "कर";
					$label[17] = "विफल किराया";
					$label[18] = "अन्य (वर्णित करें)";
					$label[19] = "कुल";
					$label['note'] = "नोट: भाग VII के तहत दी गई जानकारी को गोपनीय रखा जाएगा। हालांकि, सरकार फर्म की पहचान बताए बिना सामान्य अध्ययन के लिए जानकारी का उपयोग करने के लिए स्वतंत्र होगी।";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-VII: COST OF PRODUCTION";
					$label['title'] = "Cost of Production";
					$label[0] = "Cost of production per ".$cost_unit." of ore-mineral produced";
					$label[1] = "Sl. No.";
					$label[2] = "Item";
					$label[3] = "Cost per ".$cost_unit." (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[4] = "Direct Cost";
					$label[5] = "(a) Exploration";
					$label[6] = "(b) Mining";
					$label[7] = "(c) Beneficiation(Mechanical Only)";
					$label[8] = "Over-head cost";
					$label[9] = "Depreciation";
					$label[10] = "Interest";
					$label[11] = "Royalty";
					$label[12] = "Tip";
					$label[13] = "Average royalty paid per ".$cost_unit." during the financial year should be reported";
					$label[14] = "Payments made to DMF";
					$label[15] = "Payments made to NMET";
					$label[16] = "Taxes";
					$label[17] = "Dead Rent";
					$label[18] = "Others (specify)";
					$label[19] = "Total";
					$label['note'] = "Note: Information given under Part VII will be kept confidential. The Government, however, will be free to utilize the information for general studies without revealing the identity of the firm.";

				}
			}
			
			// ANNUAL - PART II: EMPLOYMENT & WAGES I
			if($form_name == 'employment_wages') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-2 (सेवायोजन और मजदूरी)";
					$label[0] = "1. खान पर नियुक्त पर्यक्षण कर्मचारिवृद की संख्या";
					$label[1] = "विवरण";
					$label[2] = "पूर्वतःनियोजित";
					$label[3] = "अंशतःनियोजित";
					$label[4] = "(i) स्नातक खनन इंजीनियर";
					$label[5] = "(ii) डिप्लोमा खनन इंजीनियर";
					$label[6] = "(iii) भूवैज्ञानिक";
					$label[7] = "(iv) सर्वेक्षक";
					$label[8] = "(v) अन्य प्रशासनिक और तकनीकी पर्यवेक्षण कर्मचारिवृद";
					$label[9] = "कुल:";
					$label[10] = "2. (i) खान में किए गए कार्य दिवसों की संख्या:";
					$label[11] = "(ii) प्रतिदिन पालियों की संख्या:";
					$label[12] = "(iii) वर्ष के दौरान खान में कार्य अवरुप होने के कारण ( हडताल, तालाबंदी, भारी वर्षा, श्रमिको की अनुपलब्धता, परिवहन संबंधी बाधा मांग में कमी अनार्थिक प्रचालन आदी) और प्रत्येक कारण से कार्य अवरुद्ध दिवसों की संख्या |";
					$label[13] = "कारण";
					$label[14] = "दिवसों की संख्या";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-II (Employment and Wages)";
					$label[0] = "1.Number of supervisory staff employed at the mine";
					$label[1] = "Description";
					$label[2] = "Wholly employed";
					$label[3] = "Partly employed";
					$label[4] = "(i) Graduate Mining Engineer";
					$label[5] = "(ii) Diploma Mining Engineer";
					$label[6] = "(iii) Geologist";
					$label[7] = "(iv) Surveyor";
					$label[8] = "(v) Other administrative and technical supervisory staff";
					$label[9] = "Total:";
					$label[10] = "2. (i) Number of days the mine worked:";
					$label[11] = "(ii) No. of shifts per day:";
					$label[12] = "(iii) Indicate reasons for work stoppage in the mine during the year (due to strike, lockout, heavy rain, non-availability of labour, transport bottleneck, lack of demand, uneconomic operations, etc.) and the number of days of work stoppage for each of the factors separately .";
					$label[13] = "Reasons";
					$label[14] = "No. of days";

				}
			}
			
			// ANNUAL - PART II: EMPLOYMENT & WAGES II
			if($form_name == 'employment_wages_part') { 
					$form_no = $this->getController()->getRequest()->getSession()->read('mc_form_type');
					$checkform7 = ($form_no != 7 && $form_no != 1 && $form_no != 5);
					
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-2 (सेवायोजन और मजदूरी)";
					$label['title'] = "सेवायोजन और मजदूरी (II)";
					$label[0] = "3. नियोजन और संदत्त वेतन- मजदूरी";
					$label[1] = $checkform7 ? "(टिप)" : "#";
					$label[2] = " # खनन स्थल पर खान ओर सम्बद्ध कारखाना, कर्मशाला या खनिज ड्रेसिंग संयंत्र के अनन्य सभी कर्मचारीयों सहित";
					$label[3] = "वर्ष के दौरान किसी भी एक दिन अधिकतम नियोजित व्यक्तियों की संख्या:";
					$label[4] = "(i) भूमि के नीचे कार्य";
					$label[5] = "(तारीख)";
					$label[6] = "(क) (संख्या)";
					$label[7] = "(ii) खान पर कार्य";
					$label[8] = "वर्गीकरण";
					$label[9] = "वर्ष के दौरान किए गए कुल मानव दिवसों की कुल संख्या";
					$label[10] = "वर्ष के दौरान किए गए कुल कार्य दिवसों की संख्या";
					$label[11] = "औसत दैनिक नियोजित व्यक्तियों की संख्या";
					$label[12] = "वर्ष के लिए संदत्त कुल मजदरी- वेतन<br>(₹)";
					$label[13] = "सीधे";
					$label[14] = "ढेकेपर";
					$label[15] = "कुल";
					$label[16] = "पुरष";
					$label[17] = "स्त्री";
					$label[18] = "कुल";
					$label[19] = "(1)";
					$label[20] = "2(क)";
					$label[21] = "2(ख)";
					$label[22] = "2(ग)";
					$label[23] = "(3)";
					$label[24] = "4(क)";
					$label[25] = "4(ख)";
					$label[26] = "4(ग)";
					$label[27] = "(5)";
					$label[28] = "भूमि के नीचे";
					$label[29] = "विवृत";
					$label[30] = "भूमि के ऊपर";
					$label[31] = "कुल:";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-II (Employment and Wages)";
					$label['title'] = "Employment and Wages (II)";
					$label[0] = "3. Employment and salary-wages paid";
					$label[1] = $checkform7 ? "(Tip)" : "#";
					$label[2] = " # To include all employees exclusive to the mine and attached factory, workshop or mineral dressing plant at the mine site";
					$label[3] = "Maximum number of persons employed on any one day during the year:";
					$label[4] = "(i) In workings below ground on";
					$label[5] = "(date)";
					$label[6] = "(a) <em>( number)</em>";
					$label[7] = "(ii) In all in the mine on";
					$label[8] = "Classification";
					$label[9] = "Total number of man days worked during the year";
					$label[10] = "No. of days worked during the year";
					$label[11] = "Average daily number of persons employed";
					$label[12] = "Total Wages - Salary for the year<br>(₹)";
					$label[13] = "Direct";
					$label[14] = "Contract";
					$label[15] = "Total";
					$label[16] = "Male";
					$label[17] = "Female";
					$label[18] = "Total";
					$label[19] = "(1)";
					$label[20] = "2(A)";
					$label[21] = "2(B)";
					$label[22] = "2(C)";
					$label[23] = "(3)";
					$label[24] = "4(A)";
					$label[25] = "4(B)";
					$label[26] = "4(C)";
					$label[27] = "(5)";
					$label[28] = "Below Ground";
					$label[29] = "Opencast";
					$label[30] = "Above Ground";
					$label[31] = "Total:";

				}
			}
			
			// ANNUAL - PART II: CAPITAL STRUCTURE
			if($form_name == 'capital_structure') {
				$form_no = $this->getController()->getRequest()->getSession()->read('mc_form_type');
				$checkformG1 = ($form_no == 1 && $form_no == 5);
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग-2 क (पूंजी संरचना)";
					$label['title'] = "पूंजी संरचना";
					$label[0] = "1. स्थिर आस्तिया का मूल्य";
					$label['tip'][0] = "<span title='यदि स्थिर आस्तियां एक से अधिक खानों के लिए उभय- निष्ठ हो, इस प्रकार की सभी खानों के लिए संयुक्त सूचना किसी खान की विवरणी में दें | अन्य खानों की विवरणी में उस विशेष खान के लिए केवल एक प्रतिनिर्देश दिया जाए जहां संबंधित सूचना दी गई है |'>*</span>";
					$label[1] = "(खान सज्जीकरण संयंत्र क्रमांक खान कर्मशाला, ऊर्जा और जल स्थापन के संबंध में)";
					$label[2] = "यदि यह सूचना किसी अन्य खान की विवरणी के साथ दी गई हो तो कृपया खान कोड- खान का नाम उल्लिखित करें";
					$label[3] = "खान कोड";
					$label[4] = "टिप:";
					$label[5] = 'बहुविकल्पी चयन के लिए, <kbd class="bg-secondary">Ctrl</kbd> दबाएं और चुनें';
					$label[6] = $checkformG1 ? " " : "इस पृष्ठ की सभी राशियों को रुपए में दर्ज किया जाए |";
					$label[7] = "वर्णन";
					$label[8] = "वर्ष के प्रारंभ में<br>(रु.)";
					$label[9] = "वर्ष के दौरान अभिवर्द्धन गए अतिरिक्त<br>(रु.)";
					$label[10] = "वर्ष के दौरान विक्रीत अथवा तिरस्कृत गए<br>(रु.)";
					$label[11] = "वर्ष के दौरान अवक्षयण<br>(रु.)";
					$label[12] = "कुल अंतिम शेष<br>(रु.) (2+3)-(4+5)";
					$label[13] = "प्राक्कलित बाजार कीमत";
					$label['tip'][13] = "<span class='text-dark' title='मदों (i),(ii) और (iii) के लिए वैकल्पिक, खान स्वामी की वांछा के अनुसार |'>**</span><br>";
					$label['rupee_sign'] = "(रु.)";
					$label[14] = "भूमि";
					$label['tip'][14] = "<span title='भू अर्जन पर हुए अनावर्ती व्यय सहित'>***</span>";
					$label[15] = "भवन:";
					$label[16] = "औद्योगिक";
					$label[17] = "आवासिक";
					$label[18] = "परिवहन उपकरण सहित संयत्र और मशीनरी";
					$label[19] = "उत्पादन पूर्व गवेषण, विकास, बडी मरम्मत और मशीनरी आदि की मरम्मत के लिए किए गए पूंजीगत व्यय (जैसा कि आयकर अधिनियम में विहित किया गया है)";
					$label[20] = "कुल:";
					$label[21] = "2.  वित्तीय स्त्रोत (वर्ष के अंत में) :";
					$label[22] = "(i) संदत्त शेयर पूंजी(रु.)";
					$label[23] = "(ii) स्वयं पूंजी(रु.)";
					$label[24] = "(iii) रिज़र्व और अधिशेष (सभी कर)(रु.)";
					$label[25] = "(iv) बकाया दीर्घकालिक उधार";
					$label['tip'][25] = "<span title='ऋण देने वाले संस्थाओ जैसे राज्य वित्त निगम , औद्दोगिक विकास और अन्य पब्लिक निगम सहकारी बैंकें, राष्ट्रीकृत बैंकें और अन्य स्त्रोतों के नाम और प्रत्येक स्त्रोत से उधार दी गई राशि और ब्याज की दर को विनिर्दिष्ट करें |'>(#)(रु.)</span>";
					$label[26] = "संस्था -स्त्रोत का नाम";
					$label[27] = "ऋण राशि (रु.)";
					$label[28] = "ब्याज की दर";
					$label[29] = "3. ब्याज और किराया (रु.)";
					$label[30] = "(i) वर्ष के दौरान संदत्त ब्याज";
					$label[31] = "(ii) वर्ष के दौरान संदत्त किराया (सतही किराया छोड़कर)";
					$label['rupee'] = "रु.";
					$label[32] ='** मदों (i),(ii) और (iii) के लिए वैकल्पिक, खान स्वामी की वांछा के अनुसार |' ;
					$label[33] ='*** भू अर्जन पर हुए अनावर्ती व्यय सहित' ;
					$label[34] ='(#) ऋण देने वाले संस्थाओ जैसे राज्य वित्त निगम , औद्दोगिक विकास और अन्य पब्लिक निगम सहकारी बैंकें, राष्ट्रीकृत बैंकें और अन्य स्त्रोतों के नाम और प्रत्येक स्त्रोत से उधार दी गई राशि और ब्याज की दर को विनिर्दिष्ट करें |' ;
					$label[35] ='* यदि स्थिर आस्तियां एक से अधिक खानों के लिए उभय- निष्ठ हो, इस प्रकार की सभी खानों के लिए संयुक्त सूचना किसी खान की विवरणी में दें | अन्य खानों की विवरणी में उस विशेष खान के लिए केवल एक प्रतिनिर्देश दिया जाए जहां संबंधित सूचना दी गई है |' ;
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-II A (Capital Structure)";
					$label['title'] = "Capital Structure";
					$label[0] = "1. Value of Fixed Assets";
					$label['tip'][0] = "<span title='In case the fixed assets are common to more than one mine, furnish combined information for all such mines together in any one of the mine’s return. In the returns for other mines, give only a cross reference to the particular mine's return where-in the information is included'>*</span>";
					$label[1] = "(in respect of the mine, beneficiation plant, mine work-shop, power and water installation)";
					$label[2] = "In case this information is furnished as combined information in another mine's return please specify Mine Code-Mine Name:";
					$label[3] = "Mine Code";
					$label[4] = "Tip:";
					$label[5] = 'For multiple selection, Press <kbd class="bg-secondary">Ctrl</kbd> and select';
					$label[6] = $checkformG1 ? " " : "All amounts in this page should be entered in rupees";
					$label[7] = "Description";
					$label[8] = "At the beginning of the year<br>(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[9] = "Additions during the Year<br>(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[10] = "Sold or discarded during the year<br>(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[11] = "Depreciation during the year<br>(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[12] = "Net closing Balance<br>(<i class='fa fa-rupee'>&#8377;</i>) (2+3)-(4+5)";
					$label[13] = "Estimated market value";
					$label['tip'][13] = "<span class='text-dark' title='Optional and may be furnished in respect of items (i), (ii) and (iii) if the mine owner desires'>**</span><br>";
					$label['rupee_sign'] = "(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[14] = "Land";
					$label['tip'][14] = "<span title='Including any non-recurring expenditure incurred on the acquisition of land'>***</span>";
					$label[15] = "Building:";
					$label[16] = "Industrial";
					$label[17] = "Residential";
					$label[18] = "Plant and Machinery including transport equipment";
					$label[19] = "Capitalised Expenditure such as pre-production exploration, development, major overhaul and repair to machinery etc. (As prescribed under Income Tax Act)";
					$label[20] = "Total:";
					$label[21] = "2. Source of Finance ( at the end of the year) :";
					$label[22] = "(i) Paid up Share Capital (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[23] = "(ii)Own Capital (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[24] = "(iii)Reserve and Surplus (All Types)(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[25] = "(iv)Long Term loans outstanding";
					$label['tip'][25] = "<span title='Indicate the names of the lending institutions such as State Finance Corporation, Industrial Development and other Public Corporations, Co-operative Banks, Nationalised Banks and other sources along with the amount of loan from each source and the rate of interest at which loan has been taken'>(#)</span>(<i class='fa fa-rupee'>&#8377;</i>)";
					$label[26] = "Name of the Institution-Source";
					$label[27] = "Amount of Loan (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[28] = "Rate of Interest";
					$label[29] = "3. Interest and Rent (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[30] = "(i) Interest paid during the year";
					$label[31] = "(ii) Rents (excluding surface rent) paid during the year";
					$label['rupee'] = '<i class="fa fa-rupee-sign"></i>';
					$label[32] = '** Optional and may be furnished in respect of items (i), (ii) and (iii) if the mine owner desires.';
					$label[33] = '*** Including any non-recurring expenditure incurred on the acquisition of land.';
					$label[34] = '(#) Indicate the names of the lending institutions such as State Finance Corporation, Industrial Development and other Public Corporations, Co-operative Banks, Nationalised Banks and other sources along with the amount of loan from each source and the rate of interest at which loan has been taken.';
					$label[35] = "* In case the fixed assets are common to more than one mine, furnish combined information for all such mines together in any one of the mine’s return. In the returns for other mines, give only a cross reference to the particular mine's return where-in the information is included.";

				}
			}
			
			// G - PART III: 1. QUANTITY & COST OF MATERIAL
			if($form_name == 'material_consumption_quantity') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग -3 (सामग्री की खपत)";
					$label['title'] = "1. वर्ष के दौरान उपभोग किए गए माल की मात्रा और कीमत";
					$label[0] = "वर्णन";
					$label[1] = "इकाई";
					$label[2] = "मात्रा";
					$label[3] = "मूल्य (रु.)";
					$label[4] = "(i) ईंधन";
					$label[5] = "(क) कोयला";
					$label[6] = "(ख) डीज़ल तेल";
					$label[7] = "(ग) पेट्रोल";
					$label[8] = "(घ) मिट्टी का तेल";
					$label[9] = "(ड़) गैस";
					$label[10] = "(ii) स्त्रेहक";
					$label[11] = "(क) स्नेहक तेल";
					$label[12] = "(ख) ग्रीस";
					$label[13] = "(iii) विधुत";
					$label[14] = "(क) खपत";
					$label[15] = "(ख) उत्सर्जित";
					$label[16] = "(ग) विक्रय";
					$label[17] = "(iv) विस्फोटक (भाग-4 में सभी ब्यौरे भरे)";
					$label[18] = "(v) टायर";
					$label[19] = "(vi) इमारती लकड़ी और संबल";
					$label[20] = "(vii) ड्रिल रॉड्स एवं किट्स";
					$label[21] = "(viii) अन्य अतिरिक्त पुर्जे एवं भंडार";
					$label['ton'] = "टन";
					$label['ltr'] = "लीटर";
					$label['cum'] = "क्यू. मीटर";
					$label['kgs'] = "किलोग्राम";
					$label['kwh'] = "किलोवाट";
					$label['nos'] = "संख्या";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-III (Consumption of Materials)";
					$label['title'] = "1. Quantity and cost of material consumed during the year";
					$label[0] = "Description";
					$label[1] = "Unit";
					$label[2] = "Quantity"; 
					$label[3] = "Value (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[4] = "(i) Fuel";
					$label[5] = "(a) Coal";
					$label[6] = "(b) Diesel Oil";
					$label[7] = "(c) Petrol";
					$label[8] = "(d) Kerosene";
					$label[9] = "(e) Gas";
					$label[10] = "(ii) Lubricant";
					$label[11] = "(a) Lubricant oil";
					$label[12] = "(b) Grease";
					$label[13] = "(iii) Electricity";
					$label[14] = "(a) Consumed";
					$label[15] = "(b) Generated";
					$label[16] = "(c) Sold";
					$label[17] = "(iv) Explosives (furnish full details in Part IV)";
					$label[18] = "(v) Tyres";
					$label[19] = "(vi) Timber and Supports";
					$label[20] = "(vii) Drill rods and kits";
					$label[21] = "(viii) Other spares and stores";
					$label['ton'] = "Tonnes";
					$label['ltr'] = "Ltrs.";
					$label['cum'] = "Cu.M";
					$label['kgs'] = "Kgs.";
					$label['kwh'] = "Kwh";
					$label['nos'] = "Nos.";

				}
			}
			
			// G - PART III: 2. ROYALTY / COMPENSATION / DEPRECIATION
			if($form_name == 'material_consumption_royalty') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग -3 (सामग्री की खपत)";
					$label[0] = "2. स्वामिस्व, किराया और को संदत्त डीएमएफ एवं एनएमईटी भुगतान (रु.):";
					$label[1] = "चालू वर्ष के लिए संदत्त";
					$label[2] = "पिछले बकाया के लिए संदत्त";
					$label[3] = "(क) स्वामिस्व";
					$label[4] = "(ख) विफल किराया";
					$label[5] = "(ग) सतह किराया";
					$label[6] = "(घ) डीएमएफ को संदत्त";
					$label[7] = "(ड़) एनएमईटी को संदत्त";
					$label[8] = "3. वर्ष के दौरान काटे गए वृक्षों के लिए संदत्त क्षतिपूर्ति (रु.)";
					$label[9] = "4. अवक्षयण स्थाई आस्तियां पर विवरण (रु.)";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-III (Consumption of Materials)";
					$label[0] = "2. Royalty, Rents and Payments made to DMF and NMET (<i class='fa fa-rupee'>&#8377;</i>):";
					$label[1] = "Paid for current year";
					$label[2] = "Paid towards past arrears";
					$label[3] = "(a) Royalty";
					$label[4] = "(b) Dead rent";
					$label[5] = "(c) Surface rent";
					$label[6] = "(d) Payment made to DMF";
					$label[7] = "(e) Payment made to NMET";
					$label[8] = "3. Compensation paid for felling trees during the year (<i class='fa fa-rupee'>&#8377;</i>)";
					$label[9] = "4. Depreciation on fixed assets (<i class='fa fa-rupee'>&#8377;</i>)";

				}
			}
			
			// G - PART III: TAXES / OTHER EXPENSES
			if($form_name == 'material_consumption_tax') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(5)(ग)(i) देखें";
					$label['part'] = "भाग -3 (सामग्री की खपत)";
					$label[0] = "5. कर और उपकर";
					$label[1] = "वर्ष के दौरान संदत्त राशी:";
					$label[2] = "केंद्रीय सरकार";
					$label[3] = "राज्य सरकार";
					$label[4] = "विक्रय कर";
					$label[5] = "कल्याण उपकर";
					$label[6] = "अन्य कर एवं उपकर:-";
					$label[7] = "(क) खनिज उपकर";
					$label[8] = "(ख) विफल किराया पर उपकर";
					$label[9] = "(ग) अन्य ( कृपया विवरण दें)";
					$label[10] = "6. अन्य व्यय (रु.):";
					$label[11] = "उपरिव्यय";
					$label[12] = "अनुरक्षण";
					$label[13] = "कर्मकार को संदत्त अन्य फायदों का धनमूल्य की कीमत";
					$label[14] = "वृत्तिक अभिकरण को संदत्त";
					 
				} else {
					
					$label['rule'] = "See rule 45(5)(c)(i)";
					$label['part'] = "PART-III (Consumption of Materials)";
					$label[0] = "5. Taxes and cesses";
					$label[1] = "Amount in Rupees paid during the year to:";
					$label[2] = "Central Govt.";
					$label[3] = "State Govt.";
					$label[4] = "Sales Tax";
					$label[5] = "Welfare cess";
					$label[6] = "Other taxes and cesses:-";
					$label[7] = "(a) Mineral cess";
					$label[8] = "(b) Cess on dead rent";
					$label[9] = "(c) Others (please specify)";
					$label[10] = "6. Other expenses (<i class='fa fa-rupee'>&#8377;</i>):";
					$label[11] = "Overheads";
					$label[12] = "Maintenance";
					$label[13] = "Money value of other benefits paid to workmen";
					$label[14] = "Payment made to professional agencies";

				}
			}
			
			// FORM M: Part III: END-USE MINERAL BASED INDUSTRIES - I
			if($form_name == 'mineral_based_industries') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(ख) देखें";
					$label['part'] = "भाग-3 (अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं)";
					$label['title'] = "3. अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं सुचना (लौह और इस्पात उद्योग को छोड़कर) ";
					$label[0] = "(i) उद्योग का नाम :";
					$label[1] = "संयंत्र का नाम :";
					$label[2] = "(ii) (क) राज्य:";
					$label[3] = "(ख) जिला :";
					$label[4] = "(ग) स्थान :";
					
				} else {
					
					$label['rule'] = "See rule 45(6)(b)";
					$label['part'] = "PART-III (END-USE MINERAL BASED INDUSTRIES INFO)";
					$label['title'] = "3. INFORMATION REGARDING END-USE MINERAL BASED INDUSTRIES (OTHER THAN IRON AND STEEL INDUSTRY)";
					$label[0] = "(i) Name of Industry :";
					$label[1] = "Name of Plant :";
					$label[2] = "(ii) (a) State:";
					$label[3] = "(b) District :";
					$label[4] = "(c) Location :";

				}
			}
			
			// FORM M: Part III: END-USE MINERAL BASED INDUSTRIES - II
			if($form_name == 'product_manufacture_details') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(ख) देखें";
					$label['part'] = "भाग-3 (अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं)";
					$label['title'] = "3. अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं सुचना (लौह और इस्पात उद्योग को छोड़कर) ";
					$label[0] = "(iii) निर्मित उत्पादों संबंधी ब्यौरा उनकी क्षमता और उत्पादन के साथ :";
					$label[1] = "अंतिम उत्पाद :";
					$label[2] = "वर्ष के दौरान वार्षिक संस्थापित क्षमता<br>(टनों में)";
					$label[3] = "उत्पादन (टनों में)";
					$label[4] = "पूर्व वित्त वर्ष";
					$label[5] = "वर्तमान वित्त वर्ष";
					$label[6] = "अंतिम उत्पाद";
					$label[7] = "मध्यवर्ती उत्पाद";
					$label[8] = "उप-उत्पाद";
					$label[9] = "वर्ष के दौरान शुरू किया गया विस्तार कार्यक्रम और हुई प्रगति";
					$label[10] = "विस्तार कार्यक्रम-भविष्य के लिए अभिकल्पित योजना";
					$label[11] = "वर्ष के दौरान किए गए अनुसंधान और विकास कार्यक्रम (ब्यौरा दें)";
					$label['btn'] = "अधिक जोड़ें";
					
				} else {
					
					$label['rule'] = "See rule 45(6)(b)";
					$label['part'] = "PART-III (END-USE MINERAL BASED INDUSTRIES INFO)";
					$label['title'] = "3. INFORMATION REGARDING END-USE MINERAL BASED INDUSTRIES (OTHER THAN IRON AND STEEL INDUSTRY)";
					$label[0] = "(iii) Details on products manufactured with their capacities and production :";
					$label[1] = "Products";
					$label[2] = "Annual installed capacity during the year<br>(in tonnes)";
					$label[3] = "Production (in tonnes)";
					$label[4] = "Previous financial year";
					$label[5] = "Present financial year";
					$label[6] = "FINISHED PRODUCTS";
					$label[7] = "INTERMEDIATE PRODUCTS";
					$label[8] = "BY-PRODUCTS";
					$label[9] = "Expansion programme undertaken and progress made during the year";
					$label[10] = "Expansion programme / Plan envisaged for future";
					$label[11] = "Research and Development programme carried out during the year (give details)";
					$label['btn'] = "Add more";

				}
			}
			
			// FORM M: Part III: Iron and Steel Industry
			if($form_name == 'iron_steel_industries') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(ख) देखें";
					$label['part'] = "भाग-3 (अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं)";
					$label['title'] = "4. लौह और इस्पात उद्योग के बारे में सूचना";
					$label[0] = "(सभी आंकड़े वित्तीय वर्ष के आधार पर दें)";
					$label[1] = "निर्मित उत्पादों संबंधी ब्यौरा उनकी क्षमता और उत्पादन के साथ:";
					$label[2] = "उत्पाद";
					$label[3] = "संस्थापित<br>(टनों में)";
					$label[4] = "उत्पादन (टनों में)";
					$label[5] = "पूर्व वित्त वर्ष";
					$label[6] = "वर्तमान वित्त वर्ष";
					$label[7] = "टिप्पणियां";
					$label[8] = "सिंटर";
					$label[9] = "सेल्फ फ्लक्सिंग";
					$label[10] = "सामान्य";
					$label[11] = "पैलेट्स";
					$label[12] = "कोयला";
					$label[13] = "साफ कोयला";
					$label[14] = "कोक (अपना उत्पादन)";
					$label[15] = "पिग आयरन";
					$label[16] = "गर्म धातु (कुल)";
					$label[17] = "अपने खपत के लिए गर्म धातु";
					$label[18] = "बिक्री के लिए पिग आयरन";
					$label[19] = "स्पांज अयस्क";
					$label[20] = "गर्म ब्रिकेटेड आयरन";
					$label[21] = "इस्पात";
					$label[22] = "तरल इस्पात/कच्चा इस्पात";
					$label[23] = "कुल विक्रय योग्य इस्पात";
					$label[24] = "अर्द्ध-पूर्ण इस्पात";
					$label[25] = "पूर्ण इस्पात";
					$label[26] = "टिन प्लेट";
					$label[27] = "सल्फ्यूरिक अम्ल";
					$label[28] = "रिफ्रेक्टरीज़-इंटे";
					$label[29] = "उर्वरक";
					$label[30] = "कोई भी अन्य उत्पाद/उप-उत्पाद";
					$label[31] = "ख़रीदा गया कोक (टन में)";
					$label[32] = "पूर्व वर्ष";
					$label[33] = "वर्तमान वर्ष";
					$label[34] = "वर्ष के दौरान शुरू किया गया विस्तार कार्यक्रम और हुई प्रगति:";
					$label[35] = "विस्तार कार्यक्रम/भविष्य के लिए अभिकल्पित योजना:";
					$label[36] = "वर्ष के दौरान किए गए अनुसंधान और विकास कार्यक्रम (ब्यौरा दें)";
					$label['a'] = "(क)";
					$label['b'] = "(ख)";
					$label['c'] = "(ग)";
					$label['d'] = "(घ)";
					$label['e'] = "(ड़)";
					$label['f'] = "(च)";
					$label['g'] = "(छ)";
					$label['h'] = "(ज)";
					$label['i'] = "(झ)";
					$label['j'] = "(ळ)";
					$label['k'] = "(ट)";
					$label['l'] = "(ठ)";
					
				} else {
					
					$label['rule'] = "See rule 45(6)(b)";
					$label['part'] = "PART-III (END-USE MINERAL BASED INDUSTRIES INFO)";
					$label['title'] = "4. INFORMATION REGARDING IRON AND STEEL INDUSTRY ";
					$label[0] = "(All data to be given on Financial year basis)";
					$label[1] = "Products manufactured with their capacity and production:";
					$label[2] = "Products";
					$label[3] = "Installed capacity<br>(in tonnes)";
					$label[4] = "Production (in tonnes)";
					$label[5] = "Previous financial year";
					$label[6] = "Present financial year";
					$label[7] = "Remarks";
					$label[8] = "Sinter";
					$label[9] = "Self fluxing";
					$label[10] = "Ordinary";
					$label[11] = "Pellets";
					$label[12] = "Coal";
					$label[13] = "Clean coal";
					$label[14] = "Coke (own production)";
					$label[15] = "Pig iron";
					$label[16] = "Hot metal (total)";
					$label[17] = "Hot metal for own consumption";
					$label[18] = "Pig iron for sale";
					$label[19] = "Sponge Iron";
					$label[20] = "Hot Briquetted Iron";
					$label[21] = "Steel";
					$label[22] = "Liquid Steel / Crude Steel";
					$label[23] = "Total Saleable Steel";
					$label[24] = "Semi-finished Steel";
					$label[25] = "Finished Steel";
					$label[26] = "Tin plates";
					$label[27] = "Sulphuric acid";
					$label[28] = "Refractories-bricks";
					$label[29] = "Fertilizers";
					$label[30] = "Any other product/by-product";
					$label[31] = "Coke purchased (in tonnes)";
					$label[32] = "Previous year";
					$label[33] = "Present year";
					$label[34] = "Expansion programme undertaken and progress made during the year:";
					$label[35] = "Expansion programme/Plan envisaged for future:";
					$label[36] = "Research and Development programme carried out during the year (give details):";
					$label['a'] = "(a)";
					$label['b'] = "(b)";
					$label['c'] = "(c)";
					$label['d'] = "(d)";
					$label['e'] = "(e)";
					$label['f'] = "(f)";
					$label['g'] = "(g)";
					$label['h'] = "(h)";
					$label['i'] = "(i)";
					$label['j'] = "(j)";
					$label['k'] = "(k)";
					$label['l'] = "(l)";

				}
			}
			
			// FORM M: Part III: Raw Materials Consumed In Production
			if($form_name == 'raw_material_consumed') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(ख) देखें";
					$label['part'] = "भाग-3 (अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं)";
					$label['title'] = "5. उत्पादन में उपयोग की गई कच्ची सामग्री का ब्यौरा <br>{बिजली(किलोवाट में), कोयला और पेट्रोलियम उत्पाद सहित}";
					$label[0] = "कच्ची सामग्री";
					$label[1] = "वास्तविक खपत*";
					$label[2] = "प्रक्कलित अपेक्षा आवश्यकता*";
					$label[3] = "खनिज-अयस्क-धातु-फेरो एलॉय";
					$label[4] = "वास्तविक विनिर्दिष्ट";
					$label[5] = "रासयनिक विशेषताएं";
					$label[6] = "पूर्व वित्त वर्ष";
					$label[7] = "वर्तमान वित्त वर्ष";
					$label[8] = "अगला वित्त वर्ष";
					$label[9] = "अगले से अगला वित्त वर्ष";
					$label[10] = "स्वदेशी";
					$label[11] = "आयातित";
					$label[12] = "* मात्रा टन में रिपोर्ट की जाए यदि नहीं तो इकाई बताएं |";
					
				} else {
					
					$label['rule'] = "See rule 45(6)(b)";
					$label['part'] = "PART-III (END-USE MINERAL BASED INDUSTRIES INFO)";
					$label['title'] = "5. DETAILS OF RAW MATERIALS CONSUMED IN PRODUCTION <br>{including Electricity (in KWh), Coal and Petroleum products}";
					$label[0] = "Raw Material";
					$label[1] = "Actual Consumption*";
					$label[2] = "Estimated Requirement*";
					$label[3] = "Mineral/Ore Metal/Ferro alloy";
					$label[4] = "Physical Specification";
					$label[5] = "Chemical Specification";
					$label[6] = "Previous financial year";
					$label[7] = "Present financial year";
					$label[8] = "Next financial year";
					$label[9] = "Next to Next financial year";
					$label[10] = "Indigenous";
					$label[11] = "Imported";
					$label[12] = "* Quantity to be reported in tonnes. If not please specify the unit.";

				}
			}
			
			// FORM M: Part III: Source of Supply
			if($form_name == 'source_of_supply') {
				if ($lan == 'hindi') {
					
					$label['rule'] = "नियम 45(6)(ख) देखें";
					$label['part'] = "भाग-3 (अंत्य उपयोग खनिज आधारित उद्योगों के बारे मैं)";
					$label['title'] = "6. आपूर्ति का स्त्रोत";
					$label[1] = "प्रकार@";
					$label[2] = "खनिज/अयस्क/धातु/फेरो-एलॉय";
					$label[3] = "देशी";
					$label[4] = "आयातित";
					$label[5] = "आपूर्ति कर्ता का नाम और पता";
					$label[6] = "आपूर्ति का स्त्रोत (खान प्रारंम्भिकवा क्षेत्र)";
					$label[7] = "संयंत्र से खान-रेल की दुरी दर्शाएं (किमी में)";
					$label[8] = "रेल-सडक द्वारा प्रति यूनिट परिवहन लागत";
					$label[9] = "मात्रा*";
					$label[10] = "कारखाना स्थल पर प्रति यूनिट कीमत (रु. में)";
					$label[11] = "आपूर्ति कर्ता का पूरा नाम व पता (देशवार)";
					$label[12] = "खरीदी गई मात्रा*";
					$label[13] = "कारखाना स्थल पर प्रति यूनिट लागत (रु. में)";
					$label[14] = "खान कोड";
					$label[15] = "जिला";
					$label[16] = "मोड";
					$label[17] = "प्रति यूनिटट लागत (रु. में)";
					$label[18] = "पता";
					$label[19] = "देश";
					$label[20] = "(नोट)";
					$label[21] = "@ मात्रा टन में रिपोर्ट की जाए |<br/> * यदि नहीं तो इकाई बताएं |";
					
				} else {
					
					$label['rule'] = "See rule 45(6)(b)";
					$label['part'] = "PART-III (END-USE MINERAL BASED INDUSTRIES INFO)";
					$label['title'] = "6. SOURCE OF SUPPLY";
					$label[1] = "Type@";
					$label[2] = "Mineral/Ore/Metal/Ferro-alloy";
					$label[3] = "Indigenous";
					$label[4] = "Imported";
					$label[5] = "Name and address of supplier";
					$label[6] = "Source of supply (mine or area)";
					$label[7] = "Indicate the distance of minerail to plant (in km)";
					$label[8] = "Transportation cost per unit by Rail-Road";
					$label[9] = "Quantity*";
					$label[10] = "Price per unit at factory site (in <i class='fa fa-rupee-sign'></i>)";
					$label[11] = "Name and complete address of supplier (country wise)";
					$label[12] = "Quantity purchased*";
					$label[13] = "Cost per unit at factory site (in <i class='fa fa-rupee-sign'></i>)";
					$label[14] = "Mine Code";
					$label[15] = "District";
					$label[16] = "Mode";
					$label[17] = "Cost per unit (in <i class='fa fa-rupee-sign'></i>)";
					$label[18] = "Address";
					$label[19] = "Country";
					$label[20] = "(Note)";
					$label[21] = "@ Indigenous-Imported; <br/> * Quantity to be reported in tonnes. If not please specify the unit.";

				}
			}

			return $label;
		}

		/**
		 * Set PDF (Print All) labels as per language
		 * @version 10th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function pdfLabel($lang, $returnDate, $returnType, $formNo) {

			$label = array();

			$rule_no = ($formNo == 1) ? "i" : (($formNo == 2) ? "ii" : "iii");
			$returnMonth = date('M', strtotime($returnDate));
			$returnYear = date('Y', strtotime($returnDate));
			$returnYearNext = $returnYear + 1;
			switch($formNo) {
				case 1:
					$instr['en'] = "[To be used for minerals other than Copper, Gold, Lead, Pyrites, Tin, Tungsten, Zinc and precious and semi-precious stones]";
					$instr['hn'] = "[ताम्र, स्वर्ण, सीसा, पायराइट, टिन, टंगस्टन, जिंक और मूल्यवान व अपेक्षाकृत अर्ध्द मूल्य रत्नों के अतिरिक्त खनिजों के लिए उपयोग किया जाए]";
					break;
				case 2:
					$instr['en'] = "[To be used for minerals Copper, Gold, Lead, Pyrites, Tin, Tungsten and Zinc]";
					$instr['hn'] = "[ताम्र, स्वर्ण, सीसा, पायराइट, टिन, टंगस्टन और जिंक खनिजों के उपयोग के लिए]";
					break;
				case 3:
					$instr['en'] = "[To be used for precious and semi-precious stones]";
					$instr['hn'] = "[बहूमूल्य और अर्ध्द बहूमूल्य रत्नों के लिए उपयोग के लिए]";
					break;
			}

			if ($returnType == 'MONTHLY') {

				if($lang == 'hindi') {

					$label['title']['form'] = "प्ररूप-च".$formNo;
					$label['title']['rule'] = "[नियम 45(5)(ख)(i) देखें]";
					$label['title']['for'] = "मास ".$returnMonth." ".$returnYear." के लिए";
					$label['title']['return'] = "मासिक विवरणी";
					$label['title']['instr'] = $instr['hn'];
					
					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The Regional Controller of Mines";
					$label['to']['address'][1] = "Indian Bureau of Mines";
					$label['to']['address'][2] = "Region";
					$label['to']['address'][3] = "PIN:";
					$label['to']['address'][4] = "(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)";
					$label['to']['address'][5] = "The State Government of";

				} else {

					$label['title']['form'] = "FORM F-".$formNo;
					$label['title']['rule'] = "[See rule 45(5)(b)(".$rule_no.")]";
					$label['title']['for'] = "For the Month of ".$returnMonth." ".$returnYear;
					$label['title']['return'] = "MONTHLY RETURN";
					$label['title']['instr'] = $instr['en'];
					
					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The Regional Controller of Mines";
					$label['to']['address'][1] = "Indian Bureau of Mines";
					$label['to']['address'][2] = "Region";
					$label['to']['address'][3] = "PIN:";
					$label['to']['address'][4] = "(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)";
					$label['to']['address'][5] = "The State Government of";

				}

			} else {

				if($lang == 'hindi') {

					$label['title']['form'] = "प्ररूप-छ".$formNo;
					$label['title']['rule'] = "[नियम 45(5)(ग)(i) देखें]";
					$label['title']['for'] = "वित्त वर्ष 01 अप्रैल, ".$returnYear." से 31 मार्च ".$returnYearNext;
					$label['title']['return'] = "वार्षिक विवरणी";
					$label['title']['instr'] = $instr['hn'];
					
					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The Regional Controller of Mines";
					$label['to']['address'][1] = "Indian Bureau of Mines";
					$label['to']['address'][2] = "Region";
					$label['to']['address'][3] = "PIN:";
					$label['to']['address'][4] = "<em>(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)</em>";
					$label['to']['address'][5] = "The State Government of";

				} else {

					$label['title']['form'] = "FORM G-".$formNo;
					$label['title']['rule'] = "[See rule 45(5)(c)(".$rule_no.")]";
					$label['title']['for'] = "For the financial Year 1<sup>st</sup> April, ".$returnYear." to 31<sup>st</sup> March, ".$returnYearNext;
					$label['title']['return'] = "ANNUAL RETURN";
					$label['title']['instr'] = $instr['en'];

					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The Regional Controller of Mines";
					$label['to']['address'][1] = "Indian Bureau of Mines";
					$label['to']['address'][2] = "Region";
					$label['to']['address'][3] = "PIN:";
					$label['to']['address'][4] = "<em>(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)</em>";
					$label['to']['address'][5] = "The State Government of";

				}

			}

			return $label;

		}

		/**
		 * Set PDF (Print All) labels as per language
		 * @version 31st Dec 2021
		 * @author Aniket Ganvir
		 */
		public function pdfLabelEnduser($lang, $returnDate, $returnType, $activityType) {

			$label = array();

			$returnMonth = date('M', strtotime($returnDate));
			$returnYear = date('Y', strtotime($returnDate));
			$returnYearNext = $returnYear + 1;
			// switch($formNo) {
			// 	case 1:
			// 		$instr['en'] = "[To be used for minerals other than Copper, Gold, Lead, Pyrites, Tin, Tungsten, Zinc and precious and semi-precious stones]";
			// 		$instr['hn'] = "[ताम्र, स्वर्ण, सीसा, पायराइट, टिन, टंगस्टन, जिंक और मूल्यवान व अपेक्षाकृत अर्ध्द मूल्य रत्नों के अतिरिक्त खनिजों के लिए उपयोग किया जाए]";
			// 		break;
			// 	case 2:
			// 		$instr['en'] = "[To be used for minerals Copper, Gold, Lead, Pyrites, Tin, Tungsten and Zinc]";
			// 		$instr['hn'] = "[ताम्र, स्वर्ण, सीसा, पायराइट, टिन, टंगस्टन और जिंक खनिजों के उपयोग के लिए]";
			// 		break;
			// 	case 3:
			// 		$instr['en'] = "[To be used for precious and semi-precious stones]";
			// 		$instr['hn'] = "[बहूमूल्य और अर्ध्द बहूमूल्य रत्नों के लिए उपयोग के लिए]";
			// 		break;
			// }

			if ($returnType == 'MONTHLY') {

				if($lang == 'hindi') {

					$label['title']['form'] = "प्ररूप-ठ";
					$label['title']['rule'] = "[नियम 45(6)(क) देखें]";
					$label['title']['for'] = "मास ".$returnMonth." ".$returnYear." के लिए";
					$label['title']['return'] = "मासिक विवरणी";
					
					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The State Government";
					$label['to']['address'][1] = "The Regional Controller of Mines";
					$label['to']['address'][2] = "Indian Bureau of Mines";
					$label['to']['address'][3] = "Region";
					$label['to']['address'][4] = "PIN:";
					$label['to']['address'][5] = "(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)";
					$label['to']['address'][6] = "The Chief Mineral Economist";

				} else {

					$label['title']['form'] = "FORM L";
					$label['title']['rule'] = "[See rule 45(6)(a)]";
					$label['title']['for'] = "For the Month of ".$returnMonth." ".$returnYear;
					$label['title']['return'] = "MONTHLY RETURN";
					
					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The State Government";
					$label['to']['address'][1] = "The Regional Controller of Mines";
					$label['to']['address'][2] = "Indian Bureau of Mines";
					$label['to']['address'][3] = "Region";
					$label['to']['address'][4] = "PIN:";
					$label['to']['address'][5] = "(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)";
					$label['to']['address'][6] = "The Chief Mineral Economist";

				}

			} else {

				if($lang == 'hindi') {

					$label['title']['form'] = "प्ररूप-ड";
					$label['title']['rule'] = "[नियम 45(6)(ख) देखें]";
					$label['title']['for'] = "1 अप्रैल, ".$returnYear." से 31 मार्च, ".$returnYearNext." वित्त वर्ष के लिए";
					$label['title']['return'] = "वार्षिक विवरणी";
					
					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The State Government";
					$label['to']['address'][1] = "The Regional Controller of Mines";
					$label['to']['address'][2] = "Indian Bureau of Mines";
					$label['to']['address'][3] = "Region";
					$label['to']['address'][4] = "PIN:";
					$label['to']['address'][5] = "(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)";
					$label['to']['address'][6] = "The Chief Mineral Economist";

				} else {

					$label['title']['form'] = "FORM M";
					$label['title']['rule'] = "[See rule 45(6)(b)]";
					$label['title']['for'] = "For the financial Year 1<sup>st</sup> April, ".$returnYear." to 31<sup>st</sup> March, ".$returnYearNext;
					$label['title']['return'] = "ANNUAL RETURN";

					$label['to']['to'] = "To";
					$label['to']['address'][0] = "The State Government";
					$label['to']['address'][1] = "The Regional Controller of Mines";
					$label['to']['address'][2] = "Indian Bureau of Mines";
					$label['to']['address'][3] = "Region";
					$label['to']['address'][4] = "PIN:";
					$label['to']['address'][5] = "(Please address to Regional Controller of Mines in whose territorial jurisdiction the mines falls as notified from time to time by the Controller General, Indian Bureau of Mines under rule 66 of the Mineral Conservation and Development Rules, 2017)";
					$label['to']['address'][6] = "The Chief Mineral Economist";

				}

			}

			return $label;

		}

	}
