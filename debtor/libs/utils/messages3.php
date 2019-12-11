 <?php

  function getBubbleMessages3($countpea,$countemp, $today,$countpea2,$countemp2, $today2){
    $count = 0;
    $json = '{
      "type": "flex",
      "altText": "แจ้งเตือนข้อมูลลูกหนี้ค่าไฟฟ้า",
      "contents": {
        "type": "carousel",
        "contents": [
          {
            "type": "bubble",            
            "header": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "เรื่องที่ 1",
                  "weight": "bold",
                  "color": "#1DB446",
                  "size": "sm"
                },
                {
                  "type": "text",
                  "text": "ข้อมูลลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกันของสายงานการไฟฟ้า ภาค 4",
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
                          "text": "'.$today.'",
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
                          "text": "'.$countpea.' กฟฟ. ('.$countemp.' ราย)",
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
                        "uri": "https://southpea.herokuapp.com/debtor/majorDebt"
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
          },
          {
            "type": "bubble",
            "header": {
              "type": "box",
              "layout": "vertical",
              "contents": [
                {
                  "type": "text",
                  "text": "เรื่องที่ 2",
                  "weight": "bold",
                  "color": "#1DB446",
                  "size": "sm"
                },
                {
                  "type": "text",
                  "text": "ข้อมูลลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนดของสายงานการไฟฟ้า ภาค 4",
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
                          "text": "'.$today2.'",
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
                          "text": "'.$countpea2.' กฟฟ. ('.$countemp2.' ราย)",
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
                        "uri": "https://southpea.herokuapp.com/debtor/overdue"
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
          }
        ]
      }
    }';
    $result = json_decode($json);
    return $result;
  }
