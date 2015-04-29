
    <li class="active"><?php echo $_page_title;?></li>
</ul>

<section class="panel">
    <header class="panel-heading">Admin Home</header>
    <div class="panel-body">        
        <?php
        echo 'TOKEN: '.$this->session->userdata('posios_api_token');

			//		16011,1424995200000, 1425074399000


//			echo "<br>";
//			echo "1424815200000<br>";
//			echo substr("1424815200000",0,10)."<br>";
//			echo date("d M Y",substr("1424995200000",0,10))."<br>";
//			echo PHP_EOL. "DATE: ".strtotime(convertMyDate("25/02/2015")).PHP_EOL;
//			echo "<br><br><br>";


        $lrpc = new \AppioLab\LRPC\LRPC();
        $lrpc->connectToLightspeed();
        $lrpc->setApiToken($this->session->userdata('posios_api_token'));

        $lrpc->setCompanyId("16011");
        $lrpc->setServerUrl("http://sg1.posios.com:8080/PosServer/JSON-RPC");

//		$lrpc->setCompanyId("21744");
//		$lrpc->setServerUrl("http://au1.posios.com:8080/PosServer/JSON-RPC");

//        echo "<br>";
//        $products =  $lrpc->getPaymentTypes();
//        echo "Payment types<br><pre>";
//        print_r($products->result);
//		echo "</pre>";

//			$receipts =  $lrpc->getReceiptsByDate("1424793600000", "1424879999000"); //aus
			$receipts =  $lrpc->getReceiptsByDate("1424995200000", "1425074399000");

//			echo "receipt<br>";
//			print_r($receipts);

//			echo "<br/>from ".date("d M Y h:i:s", "1424793600")." to ".date("d M Y h:i:s", "1424879999");
//			echo "<br/>".PHP_EOL;
//
		$lstoxero = new \AppioLab\LsToXero\LsToXero();



//		$types = $lstoxero->getLSPaymentGroupResult($receipts->result);
//
//			echo "Receipts types<pre>";
//			print_r($types);
//			echo "<br></pre>";

	/*		$sn = 1;
			$amount  = 0;
			echo "SN\tTypeId\t Type\t\t Amount".PHP_EOL;
			foreach($types as $type){

				if($type['paymentTypeTypeId'] == 1){
					echo $sn."\t".$type['paymentTypeTypeId']."\t".$type['type']."\t\t".$type['amount'].PHP_EOL;

					$sn++;
					$amount += $type['amount'];
				}

			}

			echo "TYPE 1 Total: ".$amount.PHP_EOL;*/


/*			$sn = 1;
			$amount  = 0;
			echo "SN\tTypeId\t Type\t\t Amount".PHP_EOL;
			foreach($types as $type){

				if($type['paymentTypeTypeId'] == 2){
					echo $sn."\t".$type['paymentTypeTypeId']."\t".$type['type']."\t\t".$type['amount'].PHP_EOL;

					$sn++;
					$amount += $type['amount'];
				}

			}

			echo "TYPE 2 Total: ".$amount.PHP_EOL;*/



			/*echo "<pre>";
			$sn = 1;
			$amount  = 0;
			echo "ALL TYPES ".PHP_EOL;
			echo "SN\tId\tTypeId\t Type\t\t Amount".PHP_EOL;
			foreach($types as $type){


//					echo $sn."\t".$type['paymentTypeId']."\t".$type['paymentTypeTypeId']."\t".$type['type']."\t\t".$type['amount'].PHP_EOL;
					$t = strlen($type['type'])>5 ?"\t":"\t\t";
					echo $sn."\t".$type['paymentTypeId']."\t".$type['paymentTypeTypeId']."\t".$type['type'] . $t .$type['amount'].PHP_EOL;

					$sn++;
					$amount += $type['amount'];


			}

			echo "TYPE ALL Total: ".$amount.PHP_EOL;
//		print_r($types);
		echo "</pre>";*/
       ?>

    </div>
</section>
<!--notification start-->

<!--notification end-->
