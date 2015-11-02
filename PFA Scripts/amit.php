<?php
require_once "Android.php";
$object = new Android();
$object->dialogCreateAlert("Quiz Game By", "Amit Kumar Mondal");
$object->dialogSetPositiveButtonText("Proceed");
$object->dialogSetNegativeButtonText("Exit");
$object->dialogShow();
$response = $object->dialogGetResponse();
$function = ($response["result"]->which=="positive") ? "proceed" : "exit";
switch($function){
	case "proceed":
		$object->dialogCreateAlert("What is Codename for MAC OS X 10.7?");
		$ans11 = array("Lion","Leopard","Snow Leopard","Tiger");
		$object->dialogSetItems($ans11);
		$object->dialogShow();
		$ans1 = $object->dialogGetResponse();
		$ans1m = "Lion";
		if($ans11[$ans1["result"]->item] == $ans1m){
			$object->dialogCreateAlert("Result","Right Answer");
			$object->dialogSetPositiveButtonText("Next");
			$object->dialogShow();
			$next = $object->dialogGetResponse();
			if($next["result"]->which == "positive"){
				$object->dialogCreateAlert("What is the new Database developed by Google?");
				$ans22 = array("NoSQL","MongoDB","F1","CouchDB");
				$object->dialogSetItems($ans22);
				$object->dialogShow();
				$ans2 = $object->dialogGetResponse();
				$ans2m = "F1";
				if($ans22[$ans2["result"]->item] == $ans2m){
					$object->dialogCreateAlert("Result","Right Answer");
					$object->dialogSetPositiveButtonText("Next");
					$object->dialogShow();
					$next = $object->dialogGetResponse();
					if($next["result"]->which == "positive"){
						$object->makeToast("Thank You for playing");
						$object->exit();
						exit(0);
					}
				}
			}
		}
		break;
	case "exit":
		$object->makeToast("Thank You for visiting");
		$object->exit();
		exit(0);
		break;
}