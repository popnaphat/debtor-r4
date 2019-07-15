 <?php

  function getBubbleMessages($countpea,$countemp, $today, $dept_name, $region){
    $count = 0;
    $json = '{
      "type": "flex",
      "altText": "แจ้งเตือนลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน",
      "contents": {
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://i.investopedia.com/thumbs/debtor.png",
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
              "text": "จำนวนลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกันของ'.$dept_name.'",
              "size": "xl",
              "weight": "bold",
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
                      "text": "'.$countpea.' กฟฟ '.$countemp.' ราย",
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
                "uri": "https://southpea.herokuapp.com/debtor/majorDebt/region.php?REQ='.$region.'"
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
