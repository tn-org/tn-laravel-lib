<?php

namespace Tnlake\Api\Enums;

/**
 * 標準的なHTTPステータスコード
 *
 * @see https://developer.mozilla.org/ja/docs/Web/HTTP/Status
 */
enum HttpStatus: int
{
    // ========================================
    // 2xx Success - リクエストが正常に処理された
    // ========================================

    /**
     * 200 OK
     * リクエストが成功した
     * 使用例: GET/PUT/PATCH リクエストの成功レスポンス
     */
    case OK = 200;

    /**
     * 201 Created
     * リクエストが成功してリソースが作成された
     * 使用例: POST リクエストで新規リソース作成成功時
     */
    case CREATED = 201;

    /**
     * 202 Accepted
     * リクエストは受理されたが、まだ処理は完了していない
     * 使用例: 非同期処理、バッチ処理のキューイング時
     */
    case ACCEPTED = 202;

    /**
     * 203 Non-Authoritative Information
     * リクエストは成功したが、返された情報はオリジナルではない
     * 使用例: プロキシサーバーが変更した情報を返す場合
     */
    case NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * 204 No Content
     * リクエストは成功したが、返すコンテンツはない
     * 使用例: DELETE成功時、PUT更新でレスポンスボディが不要な場合
     */
    case NO_CONTENT = 204;

    /**
     * 205 Reset Content
     * リクエストは成功、クライアントはビューをリセットすべき
     * 使用例: フォーム送信後にフォームをクリアする指示
     */
    case RESET_CONTENT = 205;

    /**
     * 206 Partial Content
     * 部分的なリソースを返している
     * 使用例: Range ヘッダーを使った部分的なダウンロード
     */
    case PARTIAL_CONTENT = 206;

    // ========================================
    // 3xx Redirection - 追加の処理が必要
    // ========================================

    /**
     * 300 Multiple Choices
     * 複数の選択肢がある
     * 使用例: 同じリソースに複数の表現がある場合
     */
    case MULTIPLE_CHOICES = 300;

    /**
     * 301 Moved Permanently
     * リソースは恒久的に移動した
     * 使用例: URL変更時のリダイレクト（SEOに影響）
     */
    case MOVED_PERMANENTLY = 301;

    /**
     * 302 Found
     * リソースは一時的に別の場所にある
     * 使用例: 一時的なリダイレクト、メンテナンスページへの誘導
     */
    case FOUND = 302;

    /**
     * 303 See Other
     * 他のリソースを参照せよ
     * 使用例: POST後にGETでリダイレクト（PRGパターン）
     */
    case SEE_OTHER = 303;

    /**
     * 304 Not Modified
     * リソースは変更されていない
     * 使用例: 条件付きGETでキャッシュが有効な場合
     */
    case NOT_MODIFIED = 304;

    /**
     * 307 Temporary Redirect
     * 一時的なリダイレクト（メソッド変更不可）
     * 使用例: POSTリクエストを維持したまま一時的にリダイレクト
     */
    case TEMPORARY_REDIRECT = 307;

    /**
     * 308 Permanent Redirect
     * 恒久的なリダイレクト（メソッド変更不可）
     * 使用例: POSTリクエストを維持したまま恒久的にリダイレクト
     */
    case PERMANENT_REDIRECT = 308;

    // ========================================
    // 4xx Client Error - クライアント側のエラー
    // ========================================

    /**
     * 400 Bad Request
     * リクエストが不正
     * 使用例: 不正なJSON、必須パラメータ不足、形式エラー
     */
    case BAD_REQUEST = 400;

    /**
     * 401 Unauthorized
     * 認証が必要
     * 使用例: ログインが必要、認証トークンが無効・期限切れ
     */
    case UNAUTHORIZED = 401;

    /**
     * 402 Payment Required
     * 支払いが必要（将来のために予約）
     * 使用例: 有料サービスで支払いが必要な場合
     */
    case PAYMENT_REQUIRED = 402;

    /**
     * 403 Forbidden
     * アクセス禁止
     * 使用例: 権限不足、IPアドレス制限、リソースへのアクセス拒否
     */
    case FORBIDDEN = 403;

    /**
     * 404 Not Found
     * リソースが見つからない
     * 使用例: 存在しないURL、削除済みリソース、無効なID
     */
    case NOT_FOUND = 404;

    /**
     * 405 Method Not Allowed
     * 許可されていないメソッド
     * 使用例: GETのみ許可のエンドポイントにPOSTした場合
     */
    case METHOD_NOT_ALLOWED = 405;

    /**
     * 406 Not Acceptable
     * 受け入れられない
     * 使用例: Accept ヘッダーで指定された形式で応答できない
     */
    case NOT_ACCEPTABLE = 406;

    /**
     * 407 Proxy Authentication Required
     * プロキシ認証が必要
     * 使用例: プロキシサーバーでの認証が必要
     */
    case PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * 408 Request Timeout
     * リクエストタイムアウト
     * 使用例: クライアントがリクエスト送信に時間がかかりすぎた
     */
    case REQUEST_TIMEOUT = 408;

    /**
     * 409 Conflict
     * 競合が発生
     * 使用例: 重複登録、楽観的ロック失敗、状態遷移エラー
     */
    case CONFLICT = 409;

    /**
     * 410 Gone
     * リソースは完全に削除された
     * 使用例: 意図的に削除され、復活予定のないリソース
     */
    case GONE = 410;

    /**
     * 411 Length Required
     * Content-Length ヘッダーが必要
     * 使用例: Content-Length なしでPOSTした場合
     */
    case LENGTH_REQUIRED = 411;

    /**
     * 412 Precondition Failed
     * 前提条件が失敗
     * 使用例: If-Match ヘッダーの条件が満たされない
     */
    case PRECONDITION_FAILED = 412;

    /**
     * 413 Payload Too Large
     * ペイロードが大きすぎる
     * 使用例: アップロードファイルサイズ制限超過
     */
    case PAYLOAD_TOO_LARGE = 413;

    /**
     * 414 URI Too Long
     * URIが長すぎる
     * 使用例: GETパラメータが長すぎる
     */
    case URI_TOO_LONG = 414;

    /**
     * 415 Unsupported Media Type
     * サポートされていないメディアタイプ
     * 使用例: Content-Type が受け入れられない形式
     */
    case UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * 416 Range Not Satisfiable
     * 範囲リクエストを満たせない
     * 使用例: Range ヘッダーの範囲が無効
     */
    case RANGE_NOT_SATISFIABLE = 416;

    /**
     * 417 Expectation Failed
     * Expect ヘッダーの条件を満たせない
     * 使用例: Expect: 100-continue が満たされない
     */
    case EXPECTATION_FAILED = 417;

    /**
     * 418 I'm a teapot
     * ティーポットでコーヒーは淹れられない（ジョークRFC）
     * 使用例: エイプリルフール、イースターエッグ
     */
    case IM_A_TEAPOT = 418;

    /**
     * 421 Misdirected Request
     * リクエストが誤った送信先に向けられた
     * 使用例: HTTP/2で別のホストに送信された
     */
    case MISDIRECTED_REQUEST = 421;

    /**
     * 422 Unprocessable Entity
     * 処理できないエンティティ
     * 使用例: バリデーションエラー、ビジネスルール違反
     */
    case UNPROCESSABLE_ENTITY = 422;

    /**
     * 423 Locked
     * リソースがロックされている
     * 使用例: WebDAVでリソースがロック中
     */
    case LOCKED = 423;

    /**
     * 424 Failed Dependency
     * 依存関係の失敗
     * 使用例: WebDAVで前のリクエストが失敗
     */
    case FAILED_DEPENDENCY = 424;

    /**
     * 425 Too Early
     * 早すぎるリクエスト
     * 使用例: リプレイ攻撃の可能性がある場合
     */
    case TOO_EARLY = 425;

    /**
     * 426 Upgrade Required
     * アップグレードが必要
     * 使用例: HTTPSへの切り替え要求、APIバージョン更新要求
     */
    case UPGRADE_REQUIRED = 426;

    /**
     * 428 Precondition Required
     * 前提条件が必要
     * 使用例: If-Match ヘッダーが必須の場合
     */
    case PRECONDITION_REQUIRED = 428;

    /**
     * 429 Too Many Requests
     * リクエストが多すぎる
     * 使用例: レート制限、API利用制限超過
     */
    case TOO_MANY_REQUESTS = 429;

    /**
     * 431 Request Header Fields Too Large
     * リクエストヘッダーが大きすぎる
     * 使用例: Cookieやカスタムヘッダーが大きすぎる
     */
    case REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /**
     * 451 Unavailable For Legal Reasons
     * 法的理由により利用不可
     * 使用例: 地域制限、著作権、検閲
     */
    case UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    // ========================================
    // 5xx Server Error - サーバー側のエラー
    // ========================================

    /**
     * 500 Internal Server Error
     * サーバー内部エラー
     * 使用例: 未処理の例外、予期しないエラー、設定ミス
     */
    case INTERNAL_SERVER_ERROR = 500;

    /**
     * 501 Not Implemented
     * 実装されていない
     * 使用例: 未実装の機能、サポートされていないメソッド
     */
    case NOT_IMPLEMENTED = 501;

    /**
     * 502 Bad Gateway
     * 不正なゲートウェイ
     * 使用例: プロキシやゲートウェイが無効なレスポンスを受信
     */
    case BAD_GATEWAY = 502;

    /**
     * 503 Service Unavailable
     * サービス利用不可
     * 使用例: メンテナンス中、過負荷、一時的な停止
     */
    case SERVICE_UNAVAILABLE = 503;

    /**
     * 504 Gateway Timeout
     * ゲートウェイタイムアウト
     * 使用例: プロキシがアップストリームからの応答を待ちタイムアウト
     */
    case GATEWAY_TIMEOUT = 504;

    /**
     * 505 HTTP Version Not Supported
     * HTTPバージョンがサポートされていない
     * 使用例: HTTP/3 を要求されたがサポートしていない
     */
    case HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * 506 Variant Also Negotiates
     * バリアントもネゴシエートする
     * 使用例: コンテントネゴシエーションでの循環参照
     */
    case VARIANT_ALSO_NEGOTIATES = 506;

    /**
     * 507 Insufficient Storage
     * ストレージ不足
     * 使用例: WebDAVでサーバーのディスク容量不足
     */
    case INSUFFICIENT_STORAGE = 507;

    /**
     * 508 Loop Detected
     * ループを検出
     * 使用例: WebDAVで無限ループを検出
     */
    case LOOP_DETECTED = 508;

    /**
     * 510 Not Extended
     * 拡張されていない
     * 使用例: リクエストを満たすために追加の拡張が必要
     */
    case NOT_EXTENDED = 510;

    /**
     * 511 Network Authentication Required
     * ネットワーク認証が必要
     * 使用例: キャプティブポータルでの認証が必要
     */
    case NETWORK_AUTHENTICATION_REQUIRED = 511;
}
