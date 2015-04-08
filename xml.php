<?php
	class XMLManager
	{
		private $xmlDoc = null;
		private $xmlFile = "text.xml";
		private $xmlRoot = null;
		private $xmlCounter = null;
		private $lastCounter = 0;

		function __construct() 
		{
			$this->setXml();
		}

		public function insert($dataName, $dataMsg)
		{
			$xmlMsg = $this->xmlDoc->createElement("Message");
			$xmlMsg->setAttribute("user", $dataName);
			$xmlMsg->setAttribute("value", $dataMsg);
			$this->xmlCounter->setAttribute("value", $this->lastCounter + 1);
			$this->xmlRoot->appendChild($xmlMsg);
			$this->xmlDoc->save($this->xmlFile);
		}

		public function getLastMessages($dataLastCounter)
		{
			// if dataLastCounter is higher than the lastCounter we will retrieve everything
			// because the .xml might have been deleted. 
			
			$startPosition = $this->lastCounter < $dataLastCounter ? 0 : $dataLastCounter;
			$nodeList = $this->xmlRoot->getElementsByTagName("Message");

			$arrMsg = array();
			for($i = $startPosition; $i < $nodeList->length; $i++)
			{
				$arrAttrMsg = array('value' => $nodeList->item($i)->getAttribute("value"),
							        'user' => $nodeList->item($i)->getAttribute("user"));
				$arrMsg[] = $arrAttrMsg;
			}

			$res = array('lastCounter' => $this->lastCounter, 'messages' => $arrMsg);
			return json_encode($res);
		}

		private function setXml()
		{
			$this->xmlDoc = new DOMDocument();
			if (!file_exists($this->xmlFile))
			{
				$this->xmlRoot = $this->xmlDoc->createElement("Root");
				$this->xmlDoc->appendChild($this->xmlRoot);
				$this->xmlCounter = $this->xmlDoc->createElement("LastCounter");
				$this->xmlCounter->setAttribute("value", $this->lastCounter);
				$this->xmlRoot->appendChild($this->xmlCounter);
				$this->xmlDoc->save($this->xmlFile);
			}
			else
			{
				$this->xmlDoc->load($this->xmlFile);
				$this->xmlRoot = $this->xmlDoc->documentElement;
				$this->xmlCounter = $this->xmlRoot->getElementsByTagName("LastCounter")->item(0);
				$this->lastCounter = $this->xmlCounter->getAttribute("value");
			}
		}
	}
?>
