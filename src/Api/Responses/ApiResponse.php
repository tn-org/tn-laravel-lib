<?php

namespace Tnlake\Lib\Api\Responses;

use Tnlake\Lib\Api\Enums\ApiErrorCode;
use Tnlake\Lib\Api\Enums\HttpStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiResponse
{
    public static function ok(mixed $data = null): JsonResponse
    {
        return self::success($data);
    }

    public static function ng(ApiErrorCode $code, ?array $details = null): JsonResponse
    {
        return self::error($code, $details);
    }

    /**
     * 成功レスポンスを返す
     */
    public static function success(mixed $data = null, HttpStatus $status = HttpStatus::OK): JsonResponse
    {
        return response()->json(
            [
                "success" => true,
                "result" => $data
            ],
            $status->value
        );
    }

    /**
     * エラーレスポンスを返す
     */
    public static function error(ApiErrorCode $code, ?array $details = null): JsonResponse
    {
        $error = $code->toArray();

        if ($details !== null) {
            $error["details"] = $details;
        }

        return response()->json(
            [
                "success" => false,
                "error" => $error
            ],
            $error["status"]->value
        );
    }

    /**
     * バリデーションエラーレスポンスを返す
     */
    public static function validationError(ValidationException $exception): JsonResponse
    {
        $errors = [];
        foreach ($exception->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $errors[] = [
                    "field" => $field,
                    "message" => $message
                ];
            }
        }

        return self::error(ApiErrorCode::VALIDATION_ERROR, $errors);
    }

    /**
     * ページネーションレスポンスを返す
     */
    public static function paginated($paginator, ?callable $transformer = null): JsonResponse
    {
        $items = $paginator->items();

        if ($transformer !== null) {
            $items = array_map($transformer, $items);
        }

        return self::success([
            "data" => $items,
            "meta" => [
                "current_page" => $paginator->currentPage(),
                "last_page" => $paginator->lastPage(),
                "per_page" => $paginator->perPage(),
                "total" => $paginator->total(),
                "from" => $paginator->firstItem(),
                "to" => $paginator->lastItem()
            ],
            "links" => [
                "first" => $paginator->url(1),
                "last" => $paginator->url($paginator->lastPage()),
                "prev" => $paginator->previousPageUrl(),
                "next" => $paginator->nextPageUrl()
            ]
        ]);
    }

    /**
     * アプリアップデート必須レスポンスを返す
     */
    public static function forceUpdate(?string $updateUrl = null): JsonResponse
    {
        $response = response()->json(
            [
                "success" => false,
                "forceUpdate" => true,
                "error" => ApiErrorCode::APP_UPDATE_REQUIRED->toArray()
            ],
            HttpStatus::UPGRADE_REQUIRED->value
        );

        if ($updateUrl !== null) {
            $response->headers->set("X-Update-URL", $updateUrl);
        }

        return $response;
    }

    /**
     * 新バージョン通知レスポンスを返す（リクエストは通す）
     */
    public static function withNewVersionNotification(
        $response,
        ?string $latestVersion = null,
        ?string $updateUrl = null
    ): JsonResponse {
        // 新バージョン通知ヘッダーを追加
        $response->headers->set("X-New-Version-Available", "true");

        if ($latestVersion !== null) {
            $response->headers->set("X-Latest-Version", $latestVersion);
        }

        if ($updateUrl !== null) {
            $response->headers->set("X-Update-URL", $updateUrl);
        }

        return $response;
    }

    /**
     * 削除成功レスポンスを返す
     */
    public static function deleted(): JsonResponse
    {
        return self::success(null, HttpStatus::OK);
    }

    /**
     * 作成成功レスポンスを返す
     */
    public static function created(mixed $data = null): JsonResponse
    {
        return self::success($data, HttpStatus::CREATED);
    }

    /**
     * 更新成功レスポンスを返す
     */
    public static function updated(mixed $data = null): JsonResponse
    {
        return self::success($data, HttpStatus::OK);
    }

    /**
     * No Content レスポンスを返す
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(null, HttpStatus::NO_CONTENT->value);
    }

    /**
     * Accepted レスポンスを返す（非同期処理用）
     */
    public static function accepted(mixed $data = null): JsonResponse
    {
        return self::success($data, HttpStatus::ACCEPTED);
    }

    /**
     * Not Found レスポンスを返す
     */
    public static function notFound(): JsonResponse
    {
        return self::error(ApiErrorCode::NOT_FOUND);
    }

    /**
     * Forbidden レスポンスを返す
     */
    public static function forbidden(): JsonResponse
    {
        return self::error(ApiErrorCode::UNAUTHORIZED);
    }

    /**
     * Unauthorized レスポンスを返す
     */
    public static function unauthorized(): JsonResponse
    {
        return self::error(ApiErrorCode::UNAUTHENTICATED);
    }

    /**
     * Service Unavailable レスポンスを返す
     */
    public static function serviceUnavailable(): JsonResponse
    {
        return self::error(ApiErrorCode::MAINTENANCE_MODE);
    }
}
