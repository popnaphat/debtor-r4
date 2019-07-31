<?php

  function getBubbleMessages1($empID,$email){
    $json = '{
      "type": "template",
      "altText": "ขอลงทะเบียน bot LINE",
      "template": {
        "type": "confirm",
        "actions": [
          {  
            "type":"postback",
            "label":"ยืนยันคำขอ",
            "data":"confirm'.$empID.'",
            "displayText": "โปรดยืนยันการลงทะเบียนทางอีเมล '.$email.'"
          }
        ],
        "text": "ส่งอีเมลยืนยันไปที่ '.$email.' ?"
      }
    }';
    $result = json_decode($json);
    return $result;
  }