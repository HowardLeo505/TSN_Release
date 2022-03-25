import requests
import json
import pymysql
import time

access_token = "xdfHHq47Juy9-SsLi0rUn_Y23e0rFy9M2ktr7pNz8APlfiXTwgmOpXFO-OV9qRZsK_bgJxEawjjZxcI5rvUbUabAAO2nPZu9ZSQbzILerSl8K_6nlj804eyPfDCeRXm9g4jq6aY5-ve1aKJAeraqZsxdquZWDYpBlAhuMDWTyvArUKMKfwyEax75Ci5WqcUGzKA9Ps0Y6FRK_-jYHkogBw"


def get_accesstoken(idc,secret):
    ID = idc
    SECRET = secret
    global access_token
    
    url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=" + ID +"&corpsecret="+SECRET
    #print(url)
    content = requests.get(url).json()
    #print(content)
    #getjson = json.loads(content)
    #print(getjson)
    access_token = content.get("access_token")
    return access_token
    #print(access_token)




def send_message(token):
    access_token = token
    urls = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token="+ access_token + "&debug=1"
    print(urls)
    time0 = time.time()
    time1 = int(time0)
    time2 = str(time1)
    data1 = '{"touser":"","msgtype":"template_card","agentid":1000002,"template_card":{"card_type":"button_interaction","source":{"desc":"Howard","desc_color":1},'
    taskid = '"task_id":"'+ time2 +'",'
    data2 = '"main_title":{"title":"填体温了！"},"button_list":[{"text":"填报体温","style":1,"key":"Over"}],"card_action":{"type":1,"url":""}},"enable_id_trans":0,"enable_duplicate_check":0,"duplicate_check_interval":1800}'
    #da = {"touser":"LuHaoHan","msgtype":"template_card","agentid":1000002,"template_card":{"card_type":"button_interaction","source":{"desc":"Howard","desc_color":1},"task_id":"224701","main_title":{"title":"填体温了！"},"button_list":[{"text":"填报体温","style":1,"key":"Ovwe"}],"card_action":{"type":1,"url":""}},"enable_id_trans":0,"enable_duplicate_check":0,"duplicate_check_interval":1800}
    #headers = {'Content-Type': 'application/json;charset=UTF-8'}  调试出with callback url了，推测直接把request方法里的data改成json python会自己把包当成json在传参过程中不会把"当成字段名吞掉
    fulldata = data1 + taskid + data2
    data4 = json.loads(fulldata)

    post = requests.post(url = urls,json = data4).json()
    #print(pst)
    msgid = post.get("msgid")
    print(msgid)
    

if __name__ == '__main__' :
    cid = ""
    csec = ""
    c = get_accesstoken(cid,csec)
    send_message(c)
