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
                      "text": "'.$countemp.' ราย",
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
                "uri": "https://southpea.herokuapp.com/debtor/majorDebt/region.php?REQ=J"
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
