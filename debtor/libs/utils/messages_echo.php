 <?php

  
    
    $count = 1;
    $json = '{
      "type": "flex",
      "altText": "แจ้งเตือนข้อมูลลูกหนี้ค่าไฟฟ้า",
      "contents": {
        "type": "carousel",
        "contents": [';

        $choose = "SELECT * FROM flexmsghead";
        $choose_query = mysqli_query($conn,$choose);

        while($eachhd = $choose_query->fetch_assoc()){
        $selectcdb = "SELECT * FROM '".$eachhd['tblname_db']."'";
        $cdb = mysqli_query($conn,$selectcdb);
        $countdeb = mysqli_num_rows($cdb);
        
        $selectglr = "SELECT * FROM '".$eachhd['tblupdate_name']."' ORDER BY id DESC LIMIT 1";
        $glr = mysqli_query($conn,$selectglr);
        $getlastrow = mysqli_fetch_array($glr);
        $dateupload = $getlastrow['file_upload_timestamp'];
    
        $selectcp = "SELECT * from '".$eachhd['tblname_db']."' GROUP BY sap_code";
        $cp = mysqli_query($conn,$selectcp);
        $countpea = mysqli_num_rows($cp);
    if($eachhd['headid'] < 6){    
    $json .=
          '{
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
                  "text": "'.$eachhd['tblname_th'].'ของสายงานการไฟฟ้า ภาค 4",
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
                  "contents": [
                    {
                      "type": "button",
                      "action": {
                        "type": "uri",
                        "label": "คลิกดูรายละเอียด",
                        "uri": "'.$eachhd['center_url'].'"
                      },
                      "height": "sm",
                      "style": "primary",
                      "color": "#B58E38"
                    },
                    {
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
        else{
          $json .=
          '{
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
                  "text": "'.$eachhd['tblname_th'].'ของสายงานการไฟฟ้า ภาค 4",
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
                  "contents": [
                    {
                      "type": "button",
                      "action": {
                        "type": "uri",
                        "label": "คลิกดูรายละเอียด",
                        "uri": "'.$eachhd['center_url'].'"
                      },
                      "height": "sm",
                      "style": "primary",
                      "color": "#B58E38"
                    },
                    {
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
    $show = json_decode($json);
    echo json_encode($show);
?>