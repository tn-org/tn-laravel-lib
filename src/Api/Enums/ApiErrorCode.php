<?php

namespace Tnlake\Lib\Api\Enums;

/**
 * APIエラーコード定義
 *
 * エラーコード体系:
 * 1000番台: 認証・認可系
 * 2000番台: リソース系
 * 3000番台: バリデーション系
 * 4000番台: ビジネスロジック系
 * 5000番台: システム系
 * 6000番台: クライアント系
 * 9000番台: アプリバージョン系
 */
enum ApiErrorCode: int
{
    // ========================================
    // 1000番台: 認証・認可系 (Authentication & Authorization)
    // ========================================

    /** 認証が必要 - ログインしていない、トークンが未提供 */
    case UNAUTHENTICATED = 1001;

    /** 権限不足 - 認証済みだがリソースへのアクセス権限がない */
    case UNAUTHORIZED = 1002;

    /** トークン期限切れ - アクセストークンの有効期限が切れた */
    case TOKEN_EXPIRED = 1003;

    /** 無効なトークン - トークンが改竄されているか形式が不正 */
    case TOKEN_INVALID = 1004;

    /** セッション期限切れ - ユーザーセッションがタイムアウト */
    case SESSION_EXPIRED = 1005;

    // ========================================
    // 2000番台: リソース系 (Resource Errors)
    // ========================================

    /** リソースが見つからない - 指定されたリソースが存在しない */
    case NOT_FOUND = 2001;

    /** リソース削除済み - リソースは既に削除されている */
    case RESOURCE_DELETED = 2002;

    /** リソースロック中 - 他の処理でリソースがロックされている */
    case RESOURCE_LOCKED = 2003;

    // ========================================
    // 3000番台: バリデーション系 (Validation)
    // ========================================

    /** バリデーションエラー - 入力値が検証ルールに違反 */
    case VALIDATION_ERROR = 3001;

    /** 不正な入力値 - 入力形式やデータ型が不正 */
    case INVALID_INPUT = 3002;

    /** 必須項目未入力 - 必須フィールドが空または未提供 */
    case MISSING_REQUIRED_FIELD = 3003;

    // ========================================
    // 4000番台: ビジネスロジック系 (Business Logic)
    // ========================================

    /** 操作失敗 - ビジネスロジックの処理が失敗 */
    case OPERATION_FAILED = 4001;

    /** 重複エントリ - ユニーク制約違反、既に同じデータが存在 */
    case DUPLICATE_ENTRY = 4002;

    /** 利用制限超過 - 割り当てられた利用枠を超過 */
    case QUOTA_EXCEEDED = 4003;

    /** レート制限 - API呼び出し回数制限に到達 */
    case RATE_LIMITED = 4004;

    // ========================================
    // 5000番台: システム系 (System Errors)
    // ========================================

    /** サーバーエラー - 内部サーバーエラーが発生 */
    case SERVER_ERROR = 5001;

    /** データベースエラー - DB接続失敗またはクエリエラー */
    case DATABASE_ERROR = 5002;

    /** 外部サービスエラー - 連携している外部APIでエラー発生 */
    case EXTERNAL_SERVICE_ERROR = 5003;

    /** メンテナンス中 - システムメンテナンスのため一時停止中 */
    case MAINTENANCE_MODE = 5004;

    // ========================================
    // 6000番台: クライアント系 (Client Errors)
    // ========================================

    /** 不正なリクエスト - リクエスト形式が不正 */
    case BAD_REQUEST = 6001;

    /** 許可されていないメソッド - HTTPメソッドが許可されていない */
    case METHOD_NOT_ALLOWED = 6002;

    /** サポートされていないメディアタイプ - Content-Typeが未対応 */
    case UNSUPPORTED_MEDIA_TYPE = 6003;

    // ========================================
    // 9000番台: アプリバージョン系 (App Version)
    // ========================================

    /** アプリ更新必須 - 最低バージョン要件を満たしていない */
    case APP_UPDATE_REQUIRED = 9001;

    /** 非推奨バージョン - 動作するが近日サポート終了予定 */
    case APP_VERSION_DEPRECATED = 9002;

    /**
     * 対応するHTTPステータスを取得
     */
    public function getHttpStatus(): HttpStatus
    {
        return match ($this) {
            // 401 Unauthorized
            self::UNAUTHENTICATED,
            self::TOKEN_EXPIRED,
            self::TOKEN_INVALID,
            self::SESSION_EXPIRED
                => HttpStatus::UNAUTHORIZED,
            // 403 Forbidden
            self::UNAUTHORIZED, self::QUOTA_EXCEEDED => HttpStatus::FORBIDDEN,
            // 404 Not Found
            self::NOT_FOUND => HttpStatus::NOT_FOUND,
            // 400 Bad Request
            self::BAD_REQUEST,
            self::INVALID_INPUT,
            self::MISSING_REQUIRED_FIELD,
            self::OPERATION_FAILED
                => HttpStatus::BAD_REQUEST,
            // 409 Conflict
            self::DUPLICATE_ENTRY => HttpStatus::CONFLICT,
            // 410 Gone
            self::RESOURCE_DELETED => HttpStatus::GONE,
            // 422 Unprocessable Entity
            self::VALIDATION_ERROR => HttpStatus::UNPROCESSABLE_ENTITY,
            // 423 Locked
            self::RESOURCE_LOCKED => HttpStatus::LOCKED,
            // 405 Method Not Allowed
            self::METHOD_NOT_ALLOWED => HttpStatus::METHOD_NOT_ALLOWED,
            // 415 Unsupported Media Type
            self::UNSUPPORTED_MEDIA_TYPE => HttpStatus::UNSUPPORTED_MEDIA_TYPE,
            // 426 Upgrade Required
            self::APP_UPDATE_REQUIRED, self::APP_VERSION_DEPRECATED => HttpStatus::UPGRADE_REQUIRED,
            // 429 Too Many Requests
            self::RATE_LIMITED => HttpStatus::TOO_MANY_REQUESTS,
            // 500 Internal Server Error
            self::SERVER_ERROR, self::DATABASE_ERROR, self::EXTERNAL_SERVICE_ERROR => HttpStatus::INTERNAL_SERVER_ERROR,
            // 503 Service Unavailable
            self::MAINTENANCE_MODE => HttpStatus::SERVICE_UNAVAILABLE
        };
    }

    /**
     * デフォルトの英語メッセージを取得
     * フロントエンドで未定義の場合のフォールバック用
     */
    public function getMessage(): string
    {
        return match ($this) {
            self::UNAUTHENTICATED => "Authentication required",
            self::UNAUTHORIZED => "Access denied",
            self::TOKEN_EXPIRED => "Token has expired",
            self::TOKEN_INVALID => "Invalid token",
            self::SESSION_EXPIRED => "Session has expired",
            self::NOT_FOUND => "Resource not found",
            self::RESOURCE_DELETED => "Resource has been deleted",
            self::RESOURCE_LOCKED => "Resource is locked",
            self::VALIDATION_ERROR => "Validation failed",
            self::INVALID_INPUT => "Invalid input",
            self::MISSING_REQUIRED_FIELD => "Required field missing",
            self::OPERATION_FAILED => "Operation failed",
            self::DUPLICATE_ENTRY => "Duplicate entry",
            self::QUOTA_EXCEEDED => "Quota exceeded",
            self::RATE_LIMITED => "Too many requests",
            self::SERVER_ERROR => "Server error",
            self::DATABASE_ERROR => "Database error",
            self::EXTERNAL_SERVICE_ERROR => "External service error",
            self::MAINTENANCE_MODE => "System maintenance",
            self::BAD_REQUEST => "Bad request",
            self::METHOD_NOT_ALLOWED => "Method not allowed",
            self::UNSUPPORTED_MEDIA_TYPE => "Unsupported media type",
            self::APP_UPDATE_REQUIRED => "App update required",
            self::APP_VERSION_DEPRECATED => "App version deprecated"
        };
    }

    /**
     * エラー情報を取得
     * @return array{code: int, name: string, message: string, status: HttpStatus}
     */
    public function toArray(): array
    {
        return [
            "code" => $this->value,
            "name" => $this->name,
            "message" => $this->getMessage(),
            "status" => $this->getHttpStatus()
        ];
    }
}
