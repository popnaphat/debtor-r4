<?php

  function getBubbleMessages($countemp, $today, $dept_name, $dept_code){
    $count = 0;
    $json = '{
      "type": "flex",
      "altText": "แจ้งเตือนครบกำหนดพนักงานแรกบรรจุ",
      "contents": {
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://s3-ap-southeast-1.amazonaws.com/images.humanresourcesonline.net/wp-content/uploads/2017/04/Wani-13-April-HR-Job-moves-123rf-700x420.jpg",
          "size": "full",
          "aspectRatio": "20:13",
          "aspectMode": "cover"
        },
        "body": {
          "type": "box",
          "layout": "vertical",
          "contents": [
            {
              "type": "text",
              "text": "รายชื่อพนักงานที่ครบกำหนดปรับระดับครั้งแรกของ'.$dept_name.'",
              "size": "xl",
              "weight": "bold",
              "wrap": true
            },
            {
              "type": "box",
              "layout": "vertical",
              "spacing": "sm",
              "margin": "lg",
              "contents": [
                {
                  "type": "box",
                  "layout": "baseline",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "text",
                      "text": "ประจำวันที่",
                      "flex": 0,
                      "size": "sm",
                      "color": "#AAAAAA",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "'.$today.'",
                      "flex": 0,
                      "size": "sm",
                      "color": "#666666",
                      "wrap": true
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "baseline",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "text",
                      "text": "จำนวน",
                      "flex": 0,
                      "size": "sm",
                      "color": "#AAAAAA",
                      "wrap": true
                    },
                    {
                      "type": "text",
                      "text": "'.$countemp.' คน",
                      "flex": 0,
                      "size": "sm",
                      "color": "#666666",
                      "wrap": true
                    }
                  ]
                }
              ]
            }
          ]
        },
        "footer": {
          "type": "box",
          "layout": "vertical",
          "flex": 0,
          "spacing": "sm",
          "contents": [
            {
              "type": "button",
              "action": {
                "type": "uri",
                "label": "คลิกดูรายละเอียด",
                "uri": "https://southpea.herokuapp.com/hr/emplv1-5/req_office.php?REQ='.$dept_code.'"
              },
              "height": "sm",
              "style": "primary"
            },
            {
              "type": "spacer",
              "size": "sm"
            }
          ]
        }
      }
    }';
    $result = json_decode($json);
    return $result;
  }