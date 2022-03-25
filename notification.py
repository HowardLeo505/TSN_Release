from sqlite3 import Cursor
import requests
import json
import pymysql
import time

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
    print(access_token)

def send_message():
    print(access_token)
    urls = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token="+ access_token + "&debug=1"
    print(urls)
    da = {"touser":"","msgtype":"template_card","agentid":1000002,"template_card":{"card_type":"button_interaction","source":{"desc":"Howard","desc_color":1},"main_title":{"title":"别忘了填体温！"},"button_list":[{"text":"填报体温","style":1,"key":"Over"}],"card_action":{"type":1,"url":""}},"enable_id_trans":0,"enable_duplicate_check":0,"duplicate_check_interval":1800}
    #headers = {'Content-Type': 'application/json;charset=UTF-8'}  调试出with callback url了，推测直接把request方法里的data改成json python会自己把包当成json在传参过程中不会把"当成字段名吞掉
    
    post = requests.post(url = urls,json = da).json()
    msgid = post.get("msgid")
    print(msgid)

conn = pymysql.connect(host='localhost',
                     user='',
                     password='',
                     database='')
cursor = conn.cursor()
cid = ""
csec = ""
get_accesstoken(cid,csec)
'''
sql = "SELECT dedo , morning, afternoon FROM "
cursor.execute(sql)
result = cursor.fetchall()
#print(result)
'''

CurrentTime = time.strftime("%H", time.localtime())
Intted_CurrentTime = int(CurrentTime)

if(Intted_CurrentTime < 12):
    sql = "SELECT morning FROM "
    cursor.execute(sql)
    result = cursor.fetchall()
    result1 = str(result[0])
    result2 = result1[1]
    if(result2 == 0):
        send_message()

else:
        sql = "SELECT afternoon FROM "
        cursor.execute(sql)
        result = cursor.fetchall()
        result1 = str(result[0])
        result2 = result1[1]
        if(result2 == 0):
            send_message()
        
