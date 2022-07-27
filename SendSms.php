<?php
namespace backend\widgets;

use Yii;

class SendSms extends \yii\base\Widget
{
    public $m_to;
    public $m_text = "_";
    
    public function init(){
        parent::init();
    }
   
    public function run()
    {
        parent::run();
        
        // Encoding Username and Password for Authentication
        $AUTH = "Basic " . base64_encode("username:password");
        
        // Address of the place where we send request
        // this is my api location ""
        // $URL = "http://91.204.239.44/broker-api/send";
        $URL = "this is my api location";
        
        
        // Phone Number or Nick Of Caller
         // this is my api originator ""
        // $ORIGINATOR = "3700";
        $ORIGINATOR = "0000";
        
        
        
        if(gettype($this->m_to) == "string"){
            $m_id = Yii::$app->security->generateRandomString(12);
            $postdata = json_encode([
                "messages" => [
                    "recipient" => $this->m_to,
                    "message-id" => $m_id,
                    "sms"=>[
                        "originator" => $ORIGINATOR,
                        "content"=>["text"=>$this->m_text]
                    ]
                ]
            ]);
        }elseif(gettype($this->m_to) == "array"){
            // In this situation, the variable ($this->m_to) must be in form: 
            
            
            $messages = [];
            foreach($this->m_to as $key => $one_phone){
                 $m_id = Yii::$app->security->generateRandomString(12);
                $object_array = [];
                $object_array['recipient'] = $one_phone;
                $object_array['message-id'] = $m_id;
                 
                array_push($messages, $object_array);
            }
             $postdata = json_encode([
                "priority"=>"",
                "sms"=>[
                    "originator" => $ORIGINATOR,
                    "content"=>["text"=>$this->m_text]
                ],
                "messages" => $messages
            ]);
            
        }
        
        
        
        $context = stream_context_create([
            "http" => [
                'method'  => 'POST',
                'header'  => "Authorization: " . $AUTH . "\r\n" .
                             "Accept: text/plain\r\n" .
                             "Content-Type: application/json",
                "content"=>$postdata
            ]
        ]);
        
        $homepage = file_get_contents($URL, false, $context);
        
        if($homepage == "Request is received"){
            return 1;
        }else{
            return false;
        }
    }
}
