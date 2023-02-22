<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use RuntimeException;
use App\Helpers\ResponseHelper;

class SendMessageService
{
    private string $token;
    private string $parseMode;
    private bool $disableWebPagePreview;
    private bool $disableNotification;
    private const BOT_API = 'https://api.telegram.org/bot';
    private ResponseHelper $responseHelper;

    public function __construct(
        ResponseHelper $responseHelper,
        string $parseMode = 'HTML',
        bool $disableWebPagePreview = true,
        bool $disableNotification = false
    )
    {
        $this->responseHelper = $responseHelper;
        $this->token = config('app.token');
        $this->parseMode = $parseMode;
        $this->disableWebPagePreview = $disableWebPagePreview;
        $this->disableNotification = $disableNotification;
    }

    /**
     * Отправить сообщение в telegram.
     * @param int $chatId
     * @param string $message
     * @return JsonResponse
     */
    public function sendTelegramMessage(int $chatId, string $message): JsonResponse
    {
        $ch = curl_init();
        $url = self::BOT_API . $this->token . '/SendMessage';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'text' => $message,
            'chat_id' => $chatId,
            'parse_mode' => $this->parseMode,
            'disable_web_page_preview' => $this->disableWebPagePreview,
            'disable_notification' => $this->disableNotification,
        ]));

        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result['ok'] === false) {
            throw new RuntimeException('Telegram API error. Description: ' . $result['description']);
        }

        return $this->responseHelper->emptyResponse();
    }
}