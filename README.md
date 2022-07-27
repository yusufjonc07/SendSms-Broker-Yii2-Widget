Basic useage step by step

1. Download in zip form or clone this SendSms.php file
2. Add it to among your yii2 widgets
3. Use freely:
`SendSms::widget([
                    'm_to' => $sms_phone,
                    'm_text' => $sms_text,
                ]);`

`m_to` must be full phone number without "+" in condition of a string or an array 
`m_text` must be always text of your message 

I have used it in my three big projects that made in yii2

