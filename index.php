<?php
/* get all categories */
$getCategories = isset($_GET['category']) ? $_GET['category'] : array('Any');
$categories = implode(',',$getCategories);

/* get all flags */
$getFlags = isset($_GET['flags']) ? $_GET['flags'] : array();
if (count($getFlags)) {
    $flags = '?blacklistFlags=' . implode(',',$getFlags);
}else {
    $flags = '';
}

/* var_dump($url . $categories . $flags); */

if (isset($_GET['send'])) {
    $json = getJoke($categories,$flags);
}

function getJoke($categories,$flags) {

$url  = 'https://v2.jokeapi.dev/joke/' . $categories . $flags;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);

return json_decode($result);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>joke</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
            
    <form class="cate-flags" method="GET">

        <div class="categories">
            <h3>Categories</h3>
            <label for="programming">Programming</label><br>
            <input type="checkbox" name="category[]" value="Programming"/><br>
            <label for="misc">Miscellaneous</label><br>
            <input type="checkbox" name="category[]" value="Miscellaneous"/><br>
            <label for="dark">Dark</label><br>
            <input type="checkbox" name="category[]" value="Dark"/><br>
            <label for="Pun">Pun</label><br>
            <input type="checkbox" name="category[]" value="Pun"/><br>
            <label for="Spooky">Spooky</label><br>
            <input type="checkbox" name="category[]" value="Spooky"/><br>
            <label for="Christmas">Christmas</label><br>
            <input type="checkbox" name="category[]" value="Christmas"/><br>
        </div>

        <div class="flags">
            <h3>Flags to <b>blacklist</b> (optionals)</h3>
            <label for="nsfw">nsfw</label><br>
            <input type="checkbox" name="flags[]" value="nsfw"/><br>
            <label for="religious">religious</label><br>
            <input type="checkbox" name="flags[]" value="religious"/><br>
            <label for="political">political</label><br>
            <input type="checkbox" name="flags[]" value="political"/><br>
            <label for="racist">racist</label><br>
            <input type="checkbox" name="flags[]" value="racist"/><br>
            <label for="sexist">sexist</label><br>
            <input type="checkbox" name="flags[]" value="sexist"/><br>
            <label for="explicit">explicit</label><br>
            <input type="checkbox" name="flags[]" value="explicit"/><br>
        </div>
    
        
        <input type="submit" name="send" value="Generate" class="btn-submit"/>

    </form>
    <div class="joke">
        <h3><?php echo $json -> category; ?></h3><br>
        <?php 
        if ($json -> setup) {
            echo $json -> setup . '<br>';
            echo $json -> delivery . '<br>';
        } else {
            echo $json -> joke;
        }
        ?><br>
        <?php 
        foreach ($json -> flags as $key=>$flag) {
            if ($flag) {
                echo '-' . $key . '-';
            }
        }
        ?> <br>
    </div>
        
</body>
</html>