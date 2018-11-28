<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Repositories\ConfigRepository;

class Chatwork
{
    private $uriApiChatWork = 'https://api.chatwork.com/';
    private $client = null;
    private $token = null;
    private $room = null;

    public function __construct()
    {
        $config = ConfigRepository::getConfig();
        $this->token = $config->chatwork_token;
        $this->room = $config->chatwork_room_id;
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->client = new Client([
            'base_uri' => $this->uriApiChatWork,
            'headers' => [
                'X-ChatWorkToken' => $this->token,
            ]
        ]);
    }

    public function canPostMessage()
    {
        if (is_null($this->token)) return false;
        return true;
    }

    public function postMessage($dataMes, $room = null)
    {
        $roomId = is_null($room)? $this->room : $room;
        if (is_null($roomId) || is_null($dataMes['chatwork_id'])) return false;

        $url = "v2/rooms/{$roomId}/messages";
        $message = $this->buildMessageApproveRequest($dataMes);
        $data = [
            'form_params' => [
                'body' => $message
            ]
        ];

        $res = $this->client->request('POST', $url, $data);
        if ($res) {
            return $res->getBody()->getContents();
        }
        return false;
    }

    public function deleteMessage($room = null, $messageId)
    {
        $roomId = is_null($room)? $this->room : $room;

        $url = "v2/rooms/{$roomId}/messages/{$messageId}";
        $res = $this->client->delete($url);
        if ($res) {
            return $res->getBody()->getContents();
        }
        return false;
    }

    public function buildMessageApproveRequest($data)
    {
        $message[] = "[To:{$data['chatwork_id']}] vừa được Admin đồng ý cho mượn thiết bị {$data['device_name']} (Mã thiết bị: {$data['device_code']})";
        $message[] = "Ngày mượn: {$data['start_time']}";
        if(isset($data['is_long_time']) && $data['is_long_time']) {
            $message[] = "Ngày trả: Mượn dài hạn";
        } else {
            $message[] = "Ngày trả: {$data['end_time']}";
        }
        $message[] = "Vui lòng trả đúng hạn. Xin chân thành cảm ơn!";

        return implode("\n", $message);
    }

    public function postTask($dataMes, $roomId = null) {
        $roomId = is_null($roomId)? $this->room : $roomId;
        if (is_null($roomId) || is_null($dataMes['chatwork_id'])) return false;

        $url = "v2/rooms/{$roomId}/tasks";
        $message = $this->buildMessageCreateTask($dataMes);
        $data = [
            'form_params' => $this->createTaskData($message, $dataMes['chatwork_id'], $dataMes['end_time'])
        ];

        $res = $this->client->request('POST', $url, $data);
        if ($res) {
            return $res->getBody()->getContents();
        }
        return false;
    }

    public function createTaskData($message, $targetId, $endTime) {
        return [
            'body'   => $message,
            'limit'  => !is_null($endTime) ? Carbon::parse($endTime)->timestamp : 0,
            'to_ids' => $targetId
        ];
    }

    public function buildMessageCreateTask($dataDevice)
    {
        $message[] = "[To:{$dataDevice['chatwork_id']}]";
        $message[] = "Bạn đã mượn thiết bị {$dataDevice['device_name']} vào ngày {$dataDevice['start_time']}";
        $message[] = "Đề nghị bạn trả thiết bị này trước ngày {$dataDevice['end_time']}";
        $message[] = "Xin chân thành cảm ơn!";
        return implode("\n", $message);
    }
}
