<?php

  /*
    set favorite cookies if they do not exists,
    if they do it adds to the counter
    data transmited in json format
  */
  function manage_fav_cookies(){

    //GET ThreadID if not, return false
    if(!empty($_GET["threadID"])){
    $TID = $_GET["threadID"];
    }
    else{
      return false;
    }

    //declaring variables
    $cookie_array = array();
    $cookie = array();

    //If favorites cookies is not set
    if(!isset($_COOKIE["favorites"])){
      $cookie["TID"] = $TID;
      $cookie["count"] = 1;
      array_push($cookie_array, $cookie);
    }

    //If favorites cookies is set
    else{
      $found = false;
      $cookie_array = json_decode($_COOKIE["favorites"]);

      foreach($cookie_array as $fav){
        //If we find our threadID in the Cookie Array
        if((int)$fav->TID == (int)$TID){
          echo $TID," = " ,$fav->TID, "<br>";
          $fav->count++;
          $found = true;
          break;
        }  
      }

      //If the thread ID is not found in the array
      if(!$found){
        $cookie["TID"] = $TID;
        $cookie["count"] = 1;
        array_push($cookie_array, $cookie);
      }

    }
    //push new or modified favorite to favorite cookie array
    //encode to json
    $encod_arr = json_encode($cookie_array);
    //set cookie to json value 
    setcookie("favorites" , $encod_arr, time() + (3600 * 24 * 7 * 42));
  }

  function sort_fav_cookies(){

    //if favorites is set, decode it and sort it
    if(isset($_COOKIE["favorites"])){
      $cookie_array = json_decode($_COOKIE["favorites"]);
      $sorted_arr = array();

      //making things easy to sort
      foreach($cookie_array as $cookie){
        $sorted_arr["$cookie->TID"] = $cookie->count;
      }

      //sort array, 
      arsort($sorted_arr);

      return $sorted_arr;
    }
  }

?>
