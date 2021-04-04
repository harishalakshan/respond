<?php
<?

/*

-- Instagram Auto-Liker
-- Usage: Randomly selects an image from a collection of hashtags and likes it
-- By: Jacob Elliott

*/


//Client Info
define("CLIENT_ID","*****");
define("CLIENT_SECRET","*****");
define("REDIRECT","*****");
define("USER_ID","*****");
define("ACCESS_TOKEN","*****");


//Tags to search for
    $tags = array("guitar",
		  "songwriter",
		  "fender",
		  "gibson",
		  "ibanez",
		  "gretsch",
		  "lespaul",
		  "singer",
		  "music",
		  "band",
		  "musician",
		  "musicians",
		  "drummer",
		  "drummers",
		  "guitarplayer",
		  "concert",
		  "avettbrothers",
		  "ironandwine",
		  "raylamontagne",
		  "boniver",
		  "cityandcolour",
		  "dallasgreen",
		  "localnatives",
		  "acoustic",
		  "electricguitar",
		  "piano",
		  "jazz",
		  "blues",
		  "rock",
		  "folk",
		  "bluegrass",
		  "indie",
		  "banjo",
		  "fiddle");

//Get Media for random tag
$ch = curl_init();

$rand = array_rand($tags,1);

curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/v1/tags/".$tags[$rand]."/media/recent?access_token=".ACCESS_TOKEN);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

curl_close($ch);

$media = json_decode($output);

//Select a random image to like
$rand = array_rand($media->data,1);

$image = $media->data[$rand];

//Like the random photo
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/v1/media/".$image->id."/likes");

curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, "access_token=".ACCESS_TOKEN);

curl_exec($ch);

curl_close($ch);

exit();


//Get An Access Token (Only needed once and then can be hard-coded)

if($_REQUEST['action']=="oauth")
{

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/oauth/access_token");

	curl_setopt($ch,CURLOPT_POST, 5);
	curl_setopt($ch,CURLOPT_POSTFIELDS, "client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET."&grant_type=authorization_code&redirect_uri=".urlencode(REDIRECT)."&code=".$_REQUEST['code']);

	curl_exec($ch);

	curl_close($ch);

	exit();

}

header("Location: https://api.instagram.com/oauth/authorize/?scope=likes&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT."&response_type=code");


?>
?>
