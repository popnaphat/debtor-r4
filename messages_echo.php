 <?php
require('conn.php');
  
    
    $count = 1;
    $json = '{{
      "type": "flex",
      "altText": "แจ้งเตือนข้อมูลลูกหนี้ค่าไฟฟ้า",
      "contents": {
        "type": "carousel",
        "contents": [';

        $choose = "SELECT * FROM flexmsghead";
        $choose_query = mysqli_query($conn,$choose);

        while($eachhd = $choose_query->fetch_assoc()){
        $selectcdb = "SELECT * FROM ".$eachhd['tblname_db'];
        $cdb = mysqli_query($conn,$selectcdb);
        $countdeb = mysqli_num_rows($cdb);
        
        $selectglr = "SELECT * FROM ".$eachhd['tblupdate_name']." ORDER BY id DESC LIMIT 1";
        $glr = mysqli_query($conn,$selectglr);
        $getlastrow = mysqli_fetch_array($glr);
        $dateupload = $getlastrow['file_upload_timestamp'];
    
        $selectcp = "SELECT * from ".$eachhd['tblname_db']." GROUP BY sap_code";
        $cp = mysqli_query($conn,$selectcp);
        $countpea = mysqli_num_rows($cp);
    if($eachhd['headid'] < 6){    
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
    $json .= ',{
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
    }}';
    $show = json_decode($json);
   // $show2 = json_decode($json2);
    echo json_encode($show,JSON_UNESCAPED_UNICODE).'<br>';
    //echo json_encode($show2,JSON_UNESCAPED_UNICODE).'<br>';
?>