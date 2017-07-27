<?php
include PATH."/class/properties.class.php";

/* This is the first class in the chain */

class api_functions extends properties_functions {

	public function rets_search() {
		require_once(PATH . "/vendor/autoload.php");
		$config = new \PHRETS\Configuration;
		
		$config
			->setLoginUrl(RETS_URL)
			->setUsername(RETS_USERNAME)
			->setPassword(RETS_PASSWORD)
			->setRetsVersion(RETS_VERSION)
			->setUserAgent(RETS_AGENT)
		;
		
		$rets = new \PHRETS\Session($config);
		$connect = $rets->Login();

		$system = $rets->GetSystemMetadata();

		//echo "Server Name: " . $system->getSystemDescription();

		$results = $rets->Search("Property", "resi", "(city=|Austin,Kyle,Lakeway,Cedar Park,Pflugerville,Round Rock)",
                array("Limit" => "30000", "Select" => "Matrix_Unique_ID,Latitude,Longitude,ListPrice,Address,City,StateOrProvince,PostalCode,NumMainLevelBeds,NumOtherLevelBeds,BathsHalf,NumGuestHalfBaths,NumGuestFullBaths,BathsFull,SqftTotal,LotSizeArea,YearBuilt,CoveredSpaces,SubdivisionName,MLSNumber"));
		$total = count($results);
		$sql = "TRUNCATE properties";
		$qb = $this->new_mysql($sql);
		print "Total: $total<br>";
		foreach($results as $obj=>$json) {
			$property = json_decode($json);

			$Matrix_Unique_ID = $property->Matrix_Unique_ID;
			$Latitude = $this->linkID->escape_string($property->Latitude);
			$Longitude = $this->linkID->escape_string($property->Longitude);
			$ListPrice = $this->linkID->escape_string($property->ListPrice);
			$Address = $this->linkID->escape_string($property->Address);
			$City = $this->linkID->escape_string($property->City);
			$StateOrProvince = $this->linkID->escape_string($property->StateOrProvince);
			$PostalCode = $this->linkID->escape_string($property->PostalCode);
			$NumMainLevelBeds = $this->linkID->escape_string($property->NumMainLevelBeds);
			$NumOtherLevelBeds = $this->linkID->escape_string($property->NumOtherLevelBeds);
			$BathsHalf = $this->linkID->escape_string($property->BathsHalf);
			$NumGuestHalfBaths = $this->linkID->escape_string($property->NumGuestHalfBaths);
			$NumGuestFullBaths = $this->linkID->escape_string($property->NumGuestFullBaths);
			$BathsFull = $this->linkID->escape_string($property->BathsFull);
			$SqftTotal = $this->linkID->escape_string($property->SqftTotal);
			$LotSizeArea = $this->linkID->escape_string($property->LotSizeArea);
			$YearBuilt = $this->linkID->escape_string($property->YearBuilt);
			$CoveredSpaces = $this->linkID->escape_string($property->CoveredSpaces);
			$SubdivisionName = $this->linkID->escape_string($property->SubdivisionName);
			$MLSNumber = $this->linkID->escape_string($property->MLSNumber);

			$today = date("Ymd");

			$sql = "INSERT INTO `properties` 
			(
			`Matrix_Unique_ID`,`Latitude`,`Longitude`,`ListPrice`,`Address`,`City`,
			`StateOrProvince`,`PostalCode`,`NumMainLevelBeds`,`NumOtherLevelBeds`,
			`BathsHalf`,`NumGuestHalfBaths`,`NumGuestFullBaths`,`BathsFull`,`SqftTotal`,
			`LotSizeArea`,`YearBuilt`,`CoveredSpaces`,`SubdivisionName`,`MLSNumber`,
			`date_added`,`date_updated`
			) 
			VALUES 
			(
			'$Matrix_Unique_ID','$Latitude','$Longitude','$ListPrice','$Address','$City',
			'$StateOrProvince','$PostalCode','$NumMainLevelBeds','$NumOtherLevelBeds',
			'$BathsHalf','$NumGuestHalfBaths','$NumGuestFullBaths','$BathsFull','$SqftTotal',
			'$LotSizeArea','$YearBuilt','$CoveredSpaces','$SubdivisionName','$MLSNumber',
			'$today','$today'
			)
			";
			$qb = $this->new_mysql($sql);


			print "Matrix_Unique_ID: $Matrix_Unique_ID<br>";
		}


	
	}

    public function getMainImage($matrixUniqueId='22125434') {
        date_default_timezone_set('America/New_York');
		require_once(PATH . "/vendor/autoload.php");
		$config = new \PHRETS\Configuration;
		
		$config
			->setLoginUrl(RETS_URL)
			->setUsername(RETS_USERNAME)
			->setPassword(RETS_PASSWORD)
			->setRetsVersion(RETS_VERSION)
			->setUserAgent(RETS_AGENT)
		;

        $rets = new \PHRETS\Session($config);
        $connect = $rets->Login();

        $image  = $rets->GetObject('Property', 'Photo', $matrixUniqueId, '1', 0);
        $contentType = $image[0]->getContentType();
        $fileType = $this->FileExt($contentType);

        $dir = "/" . $matrixUniqueId;
        if(!file_exists(mkdir(ATTACHMENTS.$dir,0777,true)));
        $fileName = $matrixUniqueId . "_000" . $fileType;
        $filename = ATTACHMENTS.$dir."/".$fileName;

		$img = base64_encode($image[0]->getContent());

        $fp=fopen($filename,w);
        fputs($fp,$img);
        fclose($fp);


		print "Done!";        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($mls)
    {
        try{
            $rets = loginToServer();

            $property = $rets->Search("Property", "resi", "(MLSnumber=$mls)",
                array("Select" => "*"));

            $images  = $rets->GetObject('Property', 'LargePhoto', $property[0]['Matrix_Unique_ID'], '*', 0);

            $rets->Disconnect();
//            dd($property[0]->toArray());
           return  view("propertyDetail")->with("property", $property[0]->toArray())
               ->with(["images" => $images]);

        } catch(\Exception $e) {
           return  response()->json(["message" => $e->getMessage()], 401);
        }
    }

}
?>

