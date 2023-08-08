<?php

namespace App\Services;

use App\Enum\TelegramReplyMarkup;
use Illuminate\Http\JsonResponse;
use RuntimeException;
use App\Helpers\ResponseHelper;
use App\Enum\TelegramParseMode;

class SendMessageService
{
    private const BOT_API = 'https://api.telegram.org/bot';
    private string $token;

    private string $parseMode = TelegramParseMode::HTML;
    private bool $disableWebPagePreview = true;
    private bool $disableNotification = false;

    private string $url;
    private ResponseHelper $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
        $this->token = config('app.token');
        $this->url = self::BOT_API . $this->token . '/SendMessage';
    }

    /**
     * Установить ParseMode.
     * @param string $parseMode
     * @return SendMessageService
     */
    private function setParseMode(string $parseMode): self
    {
        $this->parseMode = $parseMode;
        return $this;
    }

    /**
     * Установить предпросмотр страницы.
     * @param bool $disableWebPagePreview
     * @return SendMessageService
     */
    private function setDisableWebPagePreview(bool $disableWebPagePreview): self
    {
        $this->disableWebPagePreview = $disableWebPagePreview;
        return $this;
    }

    /**
     * Установить оповещение о сообщении.
     * @param bool $disableNotification
     * @return SendMessageService
     */
    private function setDisableNotification(bool $disableNotification): self
    {
        $this->disableNotification = $disableNotification;
        return $this;
    }

    /**
     * Отправить сообщение авторизации на сервисе в telegram.
     * @param int $chatId
     * @param string $redirectUrl
     * @return JsonResponse
     */
    public function sendAuthorizationMessage(int $chatId, string $redirectUrl): JsonResponse
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $authorizationButton = $this->buildButton($redirectUrl);

        curl_setopt($ch,
                    CURLOPT_POSTFIELDS,
                    http_build_query(
                        [
                            'text' => 'Для временной авторизации перейдите по ссылке',
                            'chat_id' => $chatId,
                            'parse_mode' => $this->parseMode,
                            'disable_web_page_preview' => $this->disableWebPagePreview,
                            'disable_notification' => $this->disableNotification,
                            'reply_markup' => $authorizationButton,
                        ]));

        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result['ok'] === false) {
            throw new RuntimeException('Telegram API error. Description: ' . $result['description']);
        }

        return $this->responseHelper->emptyResponse();
    }

    public function sendMessageWithButton($chatId): JsonResponse
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $authorizationButton = $this->buildButtonCallBack();

        curl_setopt($ch,
                    CURLOPT_POSTFIELDS,
                    http_build_query(
                        [
                            'text' => 'Для начала авторизации нажмите кнопку',
                            'chat_id' => $chatId,
                            'parse_mode' => $this->parseMode,
                            'disable_web_page_preview' => $this->disableWebPagePreview,
                            'disable_notification' => $this->disableNotification,
                            'reply_markup' => $authorizationButton,
                        ]));

        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result['ok'] === false) {
            throw new RuntimeException('Telegram API error. Description: ' . $result['description']);
        }

        return $this->responseHelper->emptyResponse();
    }

    /**
     * Формирование кнопки для telegram.
     * @param string $redirectUrl
     * @return bool|string
     */
    private function buildButton(string $redirectUrl): bool|string
    {
        return json_encode([
            TelegramReplyMarkup::INLINE_KEYBOARD =>
                [
                    [
                        [
                            'text' => 'Перейти по ссылке',
                            'url' => $redirectUrl,
                        ],
                    ]
                ],
                 'one_time_keyboard' => true
            ],JSON_PRETTY_PRINT);
    }

    /**
     * @return bool|string
     */
    private function buildButtonCallBack(): bool|string
    {
        return json_encode([
              TelegramReplyMarkup::INLINE_KEYBOARD =>
                  [
                       [
                             [
                                 'text' => 'Авторизоваться',
                                 'callback_data' => '/start',
                             ],
                       ]
                  ],
                  'one_time_keyboard' => true
              ],JSON_PRETTY_PRINT);
    }
}
