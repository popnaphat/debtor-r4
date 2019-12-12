 <?php

  function getBubbleMessages2($conn, $region_name, $sapreg){
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
        $selectcdb = "SELECT * FROM ".$eachhd['tblname_db']." where left(sap_code,1) = '$sapreg'";
        $cdb = mysqli_query($conn,$selectcdb);
        $countdeb = mysqli_num_rows($cdb);
        
        $selectglr = "SELECT * FROM ".$eachhd['tblupdate_name']." where region = '$sapreg' ORDER BY id DESC LIMIT 1";
        $glr = mysqli_query($conn,$selectglr);
        $getlastrow = mysqli_fetch_array($glr);
        $dateupload = $getlastrow['file_upload_timestamp'];
    
        $selectcp = "SELECT * from ".$eachhd['tblname_db']." where left(sap_code,1) = '$sapreg' GROUP BY sap_code";
        $cp = mysqli_query($conn,$selectcp);
        $countpea = mysqli_num_rows($cp);

    if($eachhd['headid'] < $flexnum ){    
    $json .=
          '{
            "type": "bubble",
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
                  "text": "'.$eachhd['tblname_th'].'ของ'.$region_name.'",
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
                          "text": "'.$countpea.' กฟฟ. ('.$countdeb.' ราย)",
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
                  //if($countdeb <> 0){
                    $json .=
                    '{
                      "type": "button",
                      "action": {
                        "type": "uri",
                        "label": "คลิกดูรายละเอียด",
                        "uri": "'.$eachhd['center_url'].'"
                      },
                      "height": "sm",
                      "style": "primary",
                      "color": "#B58E38"
                    },';//}
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
            }
          },';
        }
        else if($eachhd['headid'] == $flexnum){
          $json .=
          '{
            "type": "bubble",
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
                  "text": "'.$eachhd['tblname_th'].'ของ'.$region_name.'",
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
                          "text": "'.$countpea.' กฟฟ. ('.$countdeb.' ราย)",
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
                  //if($countdeb <> 0){
                    $json .=
                    '{
                      "type": "button",
                      "action": {
                        "type": "uri",
                        "label": "คลิกดูรายละเอียด",
                        "uri": "'.$eachhd['center_url'].'"
                      },
                      "height": "sm",
                      "style": "primary",
                      "color": "#B58E38"
                    },';//}
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
            }
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
