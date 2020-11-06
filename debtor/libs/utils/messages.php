<?php

  function getBubbleMessages($id, $conn, $dept_name, $sapcode){
    $reg = substr($sapcode,0,1);
    $count = 1;
    $json = '{
      "type": "flex",
      "altText": "แจ้งเตือนข้อมูลลูกหนี้ค่าไฟฟ้า",
      "contents": {
        "type": "carousel",
        "contents": [';

        $choose = "SELECT * FROM flexmsghead";
        $choose_query = mysqli_query($conn,$choose);
        $flexnum = mysqli_num_rows($choose_query);

        while($eachhd = $choose_query->fetch_assoc()){
          if($eachhd['headid'] == 7){
            $fgd = 'คน';
          }
          else{
            $fgd = 'บิล';
          }
          $selectcdb = "SELECT * FROM ".$eachhd['tblname_db']." where sap_code = '$sapcode'";
          $cdb = mysqli_query($conn,$selectcdb);
          $countdeb = mysqli_num_rows($cdb);

          $selectcp = "SELECT * FROM ".$eachhd['tblupdate_name']." ORDER BY id DESC LIMIT 1";
          $cp = mysqli_query($conn,$selectcp);
          $getlastrowcp = mysqli_fetch_array($cp);
          $dateupload = $getlastrowcp['file_upload_timestamp'];
          if($eachhd['headid'] < $flexnum ){
    $json .= '
          {
            "type": "bubble",
            "styles": {
              "footer": {
                "separator": true
              }
            },
            "header": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "เรื่องที่ '.$count.'",
                  "weight": "bold",
                  "color": "#1DB446",
                  "size": "sm"
                },
                {
                  "type": "text",
                  "text": "'.$eachhd['tblname_th'].'ของ'.$dept_name.'",
                  "weight": "bold",
                  "size": "md",
                  "margin": "md",
                  "wrap": true
                }
              ]
            },
            "body": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "box",
                  "layout": "vertical",
                  "margin": "xxl",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "box",
                      "layout": "horizontal",
                      "contents": [
                        {
                          "type": "text",
                          "text": "ข้อมูล ณ วันที่",
                          "size": "sm",
                          "color": "#ffffff",
                          "flex": 0
                        },
                        {
                          "type": "text",
                          "text": "'.$dateupload.'",
                          "size": "sm",
                          "color": "#ffffff",
                          "align": "end"
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "horizontal",
                      "contents": [
                        {
                          "type": "text",
                          "text": "จำนวน",
                          "size": "sm",
                          "color": "#ffffff",
                          "flex": 0
                        },
                        {
                          "type": "text",
                          "text": "'.$countdeb.' '.$fgd.'",
                          "size": "sm",
                          "color": "#ffffff",
                          "align": "end"
                        }
                      ]
                    },
                    {
                      "type": "spacer",
                      "size": "xxl"
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "flex": 0,
                  "spacing": "sm",
                  "contents": [';
                  if($countdeb <> 0){
                    $json .=
                    '{
                      "type": "button",
                      "action": {
                        "type": "uri",
                        "label": "คลิกดูรายละเอียด",
                        "uri": "'.$eachhd['center_url'].'/req_office.php?REQ='.$sapcode.'"
                      },
                      "height": "sm",
                      "style": "primary",
                      "color": "#B58E38"
                    },';}
                    $json .=
                    '{
                      "type": "spacer",
                      "size": "sm"
                    }
                  ]
                }
              ],
              "paddingAll": "20px",
              "backgroundColor": "#7f3f98"
            }';
            if($countdeb <> 0){
              $json .=
              ',
          "action": {
          "type": "postback",
          "label": "action",
          "data": "'.$id.'debt'.$sapcode.'"
        }';}
        $json .=
        '
          },';
        }
        else if($eachhd['headid'] == $flexnum){
          $json .=
          '
          {
            "type": "bubble",
            "styles": {
              "footer": {
                "separator": true
              }
            },
            "header": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "เรื่องที่ '.$count.'",
                  "weight": "bold",
                  "color": "#1DB446",
                  "size": "sm"
                },
                {
                  "type": "text",
                  "text": "'.$eachhd['tblname_th'].'ของ'.$dept_name.'",
                  "weight": "bold",
                  "size": "md",
                  "margin": "md",
                  "wrap": true
                }
              ]
            },
            "body": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "box",
                  "layout": "vertical",
                  "margin": "xxl",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "box",
                      "layout": "horizontal",
                      "contents": [
                        {
                          "type": "text",
                          "text": "ข้อมูล ณ วันที่",
                          "size": "sm",
                          "color": "#ffffff",
                          "flex": 0
                        },
                        {
                          "type": "text",
                          "text": "'.$dateupload.'",
                          "size": "sm",
                          "color": "#ffffff",
                          "align": "end"
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "horizontal",
                      "contents": [
                        {
                          "type": "text",
                          "text": "จำนวน",
                          "size": "sm",
                          "color": "#ffffff",
                          "flex": 0
                        },
                        {
                          "type": "text",
                          "text": "'.$countdeb.' '.$fgd.'",
                          "size": "sm",
                          "color": "#ffffff",
                          "align": "end"
                        }
                      ]
                    },
                    {
                      "type": "spacer",
                      "size": "xxl"
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "flex": 0,
                  "spacing": "sm",
                  "contents": [';
                  if($countdeb <> 0){
                    $json .=
                    '{
                      "type": "button",
                      "action": {
                        "type": "uri",
                        "label": "คลิกดูรายละเอียด",
                        "uri": "'.$eachhd['center_url'].'/req_office.php?REQ='.$sapcode.'"
                      },
                      "height": "sm",
                      "style": "primary",
                      "color": "#B58E38"
                    },';}
                    $json .=
                    '{
                      "type": "spacer",
                      "size": "sm"
                    }
                  ]
                }
              ],
              "paddingAll": "20px",
              "backgroundColor": "#7f3f98"
            }';
            if($countdeb <> 0){
              $json .=
              ',
          "action": {
          "type": "postback",
          "label": "action",
          "data": "'.$id.'debt'.$sapcode.'"
        }';}
        $json .=
        '
          }';
        }
        $count++;
      }
      $json .=          
        ']
      }
    }';
    $result = json_decode($json);
    return $result;
  }
