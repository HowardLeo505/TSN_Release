<?php

include_once "WXBizMsgCrypt.php";

#企业微信后台配置
$encodingAesKey = "";
$token = "";
$corpId = "";

$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);

/*
$msg = json_decode(file_get_contents('php://input'), true);
var_dump($msg);
$sMsgSig = $_POST["msg_signature"];
$sTimeStamp = $_POST["timestamp"];
$sNonce = $_POST["nonce"];
$sEchoStr = $_POST["echostr"];
var_dump($sMsgSig);
*/

#判断是POST还是GET请求
#$ispost = 

function getIsPostRequest()
{
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
}

if(getIsPostRequest())  {
    $ispost = 1;
    echo 'post';//dbug
} else {
    $ispost = 0;
    echo 'get';//dbug
}

$sEchoStr = "";//URL有效性响应字典
$sMsg = "";  // 解析之后的明文

print($ispost);//dbug
if ($ispost = 0){     #GET请求 做微信方验证URL有效性响应
    $sVerifyMsgSig = $_GET["msg_signature"];
    $sVerifyTimeStamp = $_GET["timestamp"];
    $sVerifyNonce = $_GET["nonce"];
    $sVerifyEchoStr = $_POST["echostr"];
    print($sVerifyMsgSig); //dbug
    //响应
    //$WXCPT
    $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
    if ($errCode == 0) {
        #var_dump($sEchoStr);
        print($sEchoStr);
        #HttpUtils.SetResponce($sEchoStr);
    } 
    else {
	    print("ERR: " . $errCode . "\n\n");
    }
}
else{ //POST请求 做接收业务数据响应
    $sReqMsgSig = $_GET["msg_signature"];
    $sReqTimeStamp = $_GET["timestamp"];
    $sReqNonce = $_GET["nonce"];
    $sMsg = "";
    $sReqData = file_get_contents("php://input");
    #echo $sReqData;
    //解析微信方请求方法
    $errCode = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
    if ($errCode == 0) {
	    // 解密成功，sMsg即为xml格式的明文
        #var_dump($sMsg);
        $reader = new XMLReader();  #初始化XMLReader
        $reader->xml($sMsg);
        $countElements = 0;
        #XMLReader读取解密出的明文XML
        do{
            if($reader->nodeType == XMLReader::ELEMENT){
                $nodeName = $reader->name;
            }
            if($reader->nodeType == XMLReader::CDATA && !empty($nodeName)){ #XMLReader本身支持CDATA类型，直接读CDATA就行
                if($nodeName == "EventKey"){
                echo $reader->value;  //dbug
                $EKey = $reader->value;
                }
            }
        }while ($reader->read());
        if($EKey == "Over"){
            require("back.php");
            $Validate = new Validate_SQLWrite();
            $ErrorCode = $Validate->chek();
            if($ErrorCode == 0){
                print('OK');
                
            }
            else if($ErrorCode == 1){
                print('Error');
            }
        }
    } 
    else {
	    print("ERR: " . $errCode . "\n\n");
	    //exit(-1);
    }
}
?>
