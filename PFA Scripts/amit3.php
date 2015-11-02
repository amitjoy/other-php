<?php
require_once "Android.php";
$obj = new Android();

$obj->dialogCreateAlert("It's time to do some crazy quizzing","Developed By Amit Kumar Mondal");
$obj->dialogSetPositiveButtonText("Start");
$obj->dialogSetNegativeButtonText("No thanks");
$obj->dialogShow();
$inp = $obj->dialogGetResponse();
if($inp["result"]->which == "positive") {

//Question 1
$qst1_opt = array("Windows 8","Windows 7","Windows Vista","Windows XP");
$qst1_ans = "Windows 7";
$qst1 = question($obj, "Q1. Which has the codename Vienna?", $qst1_opt, $qst1_ans);

//Question 2
$qst2_opt = array("Go","NoSQL","Django","AES");
$qst2_ans = "Go";
$qst2 = question($obj, "Q2. Amongst the following what is a Programming Language?", $qst2_opt, $qst2_ans);

//Question 3
$qst3_opt = array("Van Neuman","Kernighan","Rasmus Lerdorf","Belly Deriath");
$qst3_ans = "Rasmus Lerdorf";
$qst3 = question($obj, "Q3. Who is the developer of PHP?", $qst3_opt, $qst3_ans);

//Question 4
$qst4_opt = array("Library Function","Initialization Function","Module Initialization Scheme","Extension .so/.dll");
$qst4_ans = "Module Initialization Scheme";
$qst4 = question($obj, "Q4. What is the MINIT in PHP?", $qst4_opt, $qst4_ans);
 
//Question 5
$qst5_opt = array("echo()","print()","fread()","printf()");
$qst5_ans = "printf()";
$qst5 = question($obj, "Q5. Amongst which takes unlimited arguments?", $qst5_opt, $qst5_ans);

$result = $qst1 + $qst2 + $qst3 + $qst4 + $qst5;
switch($result){
case "50": $obj->dialogCreateAlert("You are awesome. You scored 50/50");
			$obj->dialogNeutralButtonText("See ya");
			$obj->dialogShow();
			$obj->makeToast("Thank You for playing");
			$object->exit();
			exit(0);
			break;
case "0" :
			$obj->dialogCreateAlert("You should learn. You scored 0/50");
			$obj->dialogNeutralButtonText("See ya");
			$obj->dialogShow();
			$obj->makeToast("Thank You for playing");
			$object->exit();
			exit(0);
			break;
default:
			$obj->dialogCreateAlert("You are good. Better luck next time. You scored ".$result."/50");
			$obj->dialogNeutralButtonText("See ya");
			$obj->dialogShow();
			$obj->makeToast("Thank You for playing");
			$obj->exit();
			exit(0);
			break;
}
}
else{
	$obj->makeToast("Thank You for visiting");
	$obj->exit();
	exit(0);
}

function question($object, $question, $options, $answer)
{
	$object->dialogCreateAlert($question);
	$object->dialogSetItems($options);
	$object->dialogShow();
	$input = $object->dialogGetResponse();
	$final_input = $options[$input["result"]->item];
	$object->dialogSetPositiveButtonText("Submit");
	if($final_input != $answer){
	$object->dialogCreateAlert("Result","Wrong Answer");
	$object->dialogNeutralButtonText("Next");
	$object->dialogShow();
	return 0;
	}
	else{
	$object->dialogCreateAlert("Result","Right Answer");
	$object->dialogNeutralButtonText("Next");
	$object->dialogShow();
	return 10;
	}

}