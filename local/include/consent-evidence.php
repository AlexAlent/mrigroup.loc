<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!function_exists('mriConsentPrivateRoot')) {
    function mriConsentPrivateRoot()
    {
        $documentRoot = rtrim(
            (string)($_SERVER['DOCUMENT_ROOT'] ?? ''),
            '/\\'
        );

        if ($documentRoot === '') {
            return '';
        }

        return dirname($documentRoot)
            . '/private/consent-evidence';
    }
}

if (!function_exists('mriConsentEnsurePrivateRoot')) {
    function mriConsentEnsurePrivateRoot()
    {
        $privateRoot = mriConsentPrivateRoot();

        if ($privateRoot === '') {
            return '';
        }

        if (
            !is_dir($privateRoot)
            && !@mkdir($privateRoot, 0700, true)
            && !is_dir($privateRoot)
        ) {
            error_log(
                'Consent evidence directory could not be created.'
            );

            return '';
        }

        @chmod($privateRoot, 0700);

        return $privateRoot;
    }
}

if (!function_exists('mriConsentGetKey')) {
    function mriConsentGetKey()
    {
        $privateRoot = mriConsentEnsurePrivateRoot();

        if ($privateRoot === '') {
            return false;
        }

        $keyFile = $privateRoot . '/.consent-log.key';

        if (!is_file($keyFile)) {
            try {
                $key = random_bytes(32);
            } catch (Throwable $error) {
                $key = hash(
                    'sha256',
                    uniqid((string)mt_rand(), true),
                    true
                );
            }

            if (
                @file_put_contents(
                    $keyFile,
                    $key,
                    LOCK_EX
                ) === false
            ) {
                error_log(
                    'Consent evidence key could not be created.'
                );

                return false;
            }

            @chmod($keyFile, 0600);
        }

        $key = @file_get_contents($keyFile);

        if ($key === false || $key === '') {
            return false;
        }

        return $key;
    }
}

if (!function_exists('mriConsentEvidenceId')) {
    function mriConsentEvidenceId()
    {
        try {
            return date('YmdHis') . '-' . bin2hex(random_bytes(8));
        } catch (Throwable $error) {
            return date('YmdHis') . '-' . sha1(
                uniqid((string)mt_rand(), true)
            );
        }
    }
}

if (!function_exists('mriConsentLimitText')) {
    function mriConsentLimitText($value, $length)
    {
        $value = trim((string)$value);

        if (function_exists('mb_substr')) {
            return mb_substr($value, 0, $length, 'UTF-8');
        }

        return substr($value, 0, $length);
    }
}

if (!function_exists('mriConsentNormalizePhone')) {
    function mriConsentNormalizePhone($value)
    {
        $digits = preg_replace('/\D+/', '', (string)$value);

        if (strlen($digits) === 11 && $digits[0] === '8') {
            $digits = '7' . substr($digits, 1);
        } elseif (strlen($digits) === 10) {
            $digits = '7' . $digits;
        }

        return $digits;
    }
}

if (!function_exists('mriConsentNormalizeEmail')) {
    function mriConsentNormalizeEmail($value)
    {
        $email = trim((string)$value);

        if (function_exists('mb_strtolower')) {
            return mb_strtolower($email, 'UTF-8');
        }

        return strtolower($email);
    }
}

if (!function_exists('mriConsentLookupHash')) {
    function mriConsentLookupHash($type, $value)
    {
        $key = mriConsentGetKey();

        if ($key === false) {
            return '';
        }

        if ($type === 'phone') {
            $normalized = mriConsentNormalizePhone($value);
        } elseif ($type === 'email') {
            $normalized = mriConsentNormalizeEmail($value);
        } else {
            $normalized = trim((string)$value);
        }

        if ($normalized === '') {
            return '';
        }

        return hash_hmac(
            'sha256',
            $type . ':' . $normalized,
            $key
        );
    }
}

if (!function_exists('mriConsentMaskPhone')) {
    function mriConsentMaskPhone($value)
    {
        $digits = mriConsentNormalizePhone($value);

        if (strlen($digits) < 4) {
            return '';
        }

        return '+7 (***) ***-'
            . substr($digits, -4, 2)
            . '-'
            . substr($digits, -2);
    }
}

if (!function_exists('mriConsentMaskEmail')) {
    function mriConsentMaskEmail($value)
    {
        $email = mriConsentNormalizeEmail($value);

        if (
            $email === ''
            || strpos($email, '@') === false
        ) {
            return '';
        }

        [$local, $domain] = explode('@', $email, 2);

        if ($local === '') {
            return '***@' . $domain;
        }

        $first = function_exists('mb_substr')
            ? mb_substr($local, 0, 1, 'UTF-8')
            : substr($local, 0, 1);

        return $first . '***@' . $domain;
    }
}

if (!function_exists('mriBuildConsentEvidence')) {
    function mriBuildConsentEvidence(
        $formType,
        array $consents,
        $consentVersion,
        $formUrl = '',
        array $identifiers = []
    ) {
        try {
            $date = new DateTimeImmutable(
                'now',
                new DateTimeZone('Europe/Moscow')
            );
        } catch (Throwable $error) {
            $date = new DateTimeImmutable('now');
        }

        $phone = (string)($identifiers['phone'] ?? '');
        $email = (string)($identifiers['email'] ?? '');

        return [
            'evidence_id' => mriConsentEvidenceId(),
            'submitted_at' => $date->format(DateTimeInterface::ATOM),
            'form_type' => mriConsentLimitText($formType, 100),
            'site_host' => mriConsentLimitText(
                $_SERVER['HTTP_HOST'] ?? '',
                255
            ),
            'form_url' => mriConsentLimitText($formUrl, 2000),
            'ip_address' => mriConsentLimitText(
                $_SERVER['REMOTE_ADDR'] ?? '',
                64
            ),
            'user_agent' => mriConsentLimitText(
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                1000
            ),
            'consent_version' => mriConsentLimitText(
                $consentVersion,
                100
            ),
            'phone_lookup_hmac' =>
                mriConsentLookupHash('phone', $phone),
            'email_lookup_hmac' =>
                mriConsentLookupHash('email', $email),
            'phone_masked' =>
                mriConsentMaskPhone($phone),
            'email_masked' =>
                mriConsentMaskEmail($email),
            'personal_data_consent' =>
                !empty($consents['personal_data']),
            'privacy_acknowledged' =>
                !empty($consents['privacy']),
            'advertising_consent' =>
                !empty($consents['advertising']),
        ];
    }
}

if (!function_exists('mriFormatConsentEvidence')) {
    function mriFormatConsentEvidence(array $record)
    {
        return implode(PHP_EOL, [
            '--- Подтверждение согласий ---',
            'ID подтверждения: '
                . ($record['evidence_id'] ?? ''),
            'Дата и время: '
                . ($record['submitted_at'] ?? ''),
            'Тип формы: '
                . ($record['form_type'] ?? ''),
            'Страница: '
                . ($record['form_url'] ?? ''),
            'IP-адрес: '
                . ($record['ip_address'] ?? ''),
            'User-Agent: '
                . ($record['user_agent'] ?? ''),
            'Согласие на обработку персональных данных: '
                . (!empty($record['personal_data_consent'])
                    ? 'Да'
                    : 'Нет'),
            'Ознакомление с политикой: '
                . (!empty($record['privacy_acknowledged'])
                    ? 'Да'
                    : 'Нет'),
            'Согласие на рекламные сообщения: '
                . (!empty($record['advertising_consent'])
                    ? 'Да'
                    : 'Нет'),
            'Версия текстов согласий: '
                . ($record['consent_version'] ?? ''),
        ]);
    }
}

if (!function_exists('mriConsentRecordSignature')) {
    function mriConsentRecordSignature(array $record)
    {
        $key = mriConsentGetKey();

        if ($key === false) {
            return '';
        }

        unset($record['hmac_sha256']);

        $json = json_encode(
            $record,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        );

        if ($json === false) {
            return '';
        }

        return hash_hmac('sha256', $json, $key);
    }
}

if (!function_exists('mriVerifyConsentEvidence')) {
    function mriVerifyConsentEvidence(array $record)
    {
        $stored = (string)($record['hmac_sha256'] ?? '');

        if ($stored === '') {
            return false;
        }

        $calculated = mriConsentRecordSignature($record);

        return $calculated !== ''
            && hash_equals($stored, $calculated);
    }
}

if (!function_exists('mriWriteConsentEvidence')) {
    function mriWriteConsentEvidence(array $record)
    {
        $privateRoot = mriConsentEnsurePrivateRoot();

        if ($privateRoot === '') {
            return false;
        }

        $signature = mriConsentRecordSignature($record);

        if ($signature === '') {
            return false;
        }

        $record['hmac_sha256'] = $signature;

        $line = json_encode(
            $record,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        );

        if ($line === false) {
            return false;
        }

        $logFile =
            $privateRoot
            . '/consents-'
            . date('Y-m')
            . '.jsonl';

        $written = @file_put_contents(
            $logFile,
            $line . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

        if ($written === false) {
            error_log(
                'Consent evidence record could not be written.'
            );

            return false;
        }

        @chmod($logFile, 0600);

        return true;
    }
}

if (!function_exists('mriFindConsentEvidence')) {
    function mriFindConsentEvidence($query, $limit = 100)
    {
        $query = trim((string)$query);

        if ($query === '') {
            return [];
        }

        $privateRoot = mriConsentPrivateRoot();

        if (
            $privateRoot === ''
            || !is_dir($privateRoot)
        ) {
            return [];
        }

        $phoneHash = mriConsentLookupHash('phone', $query);
        $emailHash = mriConsentLookupHash('email', $query);

        $files = glob(
            $privateRoot . '/consents-*.jsonl'
        ) ?: [];

        rsort($files, SORT_STRING);

        $matches = [];

        foreach ($files as $file) {
            $handle = @fopen($file, 'rb');

            if (!$handle) {
                continue;
            }

            while (($line = fgets($handle)) !== false) {
                $record = json_decode($line, true);

                if (!is_array($record)) {
                    continue;
                }

                $isMatch =
                    hash_equals(
                        (string)($record['evidence_id'] ?? ''),
                        $query
                    )
                    || (
                        $phoneHash !== ''
                        && hash_equals(
                            (string)(
                                $record['phone_lookup_hmac']
                                ?? ''
                            ),
                            $phoneHash
                        )
                    )
                    || (
                        $emailHash !== ''
                        && hash_equals(
                            (string)(
                                $record['email_lookup_hmac']
                                ?? ''
                            ),
                            $emailHash
                        )
                    );

                if (!$isMatch) {
                    continue;
                }

                $record['_signature_valid'] =
                    mriVerifyConsentEvidence($record);
                $record['_source_file'] =
                    basename($file);

                $matches[] = $record;

                if (count($matches) >= $limit) {
                    break 2;
                }
            }

            fclose($handle);
        }

        usort(
            $matches,
            static function (array $left, array $right) {
                return strcmp(
                    (string)($right['submitted_at'] ?? ''),
                    (string)($left['submitted_at'] ?? '')
                );
            }
        );

        return $matches;
    }
}


/**
 * Расширенная работа с отзывами согласий.
 * Исходные записи не изменяются: отзыв и его исполнение добавляются
 * отдельными подписанными событиями.
 */

if (!function_exists('mriConsentNowV2')) {
    function mriConsentNowV2()
    {
        try {
            return new DateTimeImmutable(
                'now',
                new DateTimeZone('Europe/Moscow')
            );
        } catch (Throwable $error) {
            return new DateTimeImmutable('now');
        }
    }
}

if (!function_exists('mriConsentParseDateV2')) {
    function mriConsentParseDateV2($value)
    {
        $value = trim((string)$value);

        if ($value === '') {
            return mriConsentNowV2();
        }

        try {
            return new DateTimeImmutable(
                $value,
                new DateTimeZone('Europe/Moscow')
            );
        } catch (Throwable $error) {
            return mriConsentNowV2();
        }
    }
}

if (!function_exists('mriConsentAdminIdentityV2')) {
    function mriConsentAdminIdentityV2()
    {
        global $USER;

        return [
            'admin_user_id' =>
                is_object($USER) ? (int)$USER->GetID() : 0,
            'admin_login' =>
                is_object($USER)
                    ? mriConsentLimitText($USER->GetLogin(), 255)
                    : '',
        ];
    }
}

if (!function_exists('mriConsentReadAllV2')) {
    function mriConsentReadAllV2()
    {
        $root = mriConsentPrivateRoot();

        if ($root === '' || !is_dir($root)) {
            return [];
        }

        $files = glob($root . '/consents-*.jsonl') ?: [];
        sort($files, SORT_STRING);

        $records = [];

        foreach ($files as $file) {
            $handle = @fopen($file, 'rb');

            if (!$handle) {
                continue;
            }

            while (($line = fgets($handle)) !== false) {
                $record = json_decode($line, true);

                if (!is_array($record)) {
                    continue;
                }

                /*
                 * Сначала проверяем исходную запись.
                 * Старые записи были подписаны без event_type.
                 */
                $record['_signature_valid'] =
                    mriVerifyConsentEvidence($record);
                $record['_source_file'] = basename($file);

                if (empty($record['event_type'])) {
                    $record['event_type'] = 'consent';
                }

                $records[] = $record;
            }

            fclose($handle);
        }

        return $records;
    }
}

if (!function_exists('mriConsentQueryMatchV2')) {
    function mriConsentQueryMatchV2(
        array $record,
        $query,
        $phoneHash,
        $emailHash
    ) {
        foreach ([
            $record['evidence_id'] ?? '',
            $record['event_id'] ?? '',
            $record['target_evidence_id'] ?? '',
            $record['target_revocation_id'] ?? '',
        ] as $id) {
            $id = (string)$id;

            if ($id !== '' && hash_equals($id, $query)) {
                return true;
            }
        }

        if (
            $phoneHash !== ''
            && hash_equals(
                (string)($record['phone_lookup_hmac'] ?? ''),
                $phoneHash
            )
        ) {
            return true;
        }

        if (
            $emailHash !== ''
            && hash_equals(
                (string)($record['email_lookup_hmac'] ?? ''),
                $emailHash
            )
        ) {
            return true;
        }

        return false;
    }
}

if (!function_exists('mriConsentExecutionScopesV2')) {
    function mriConsentExecutionScopesV2($action)
    {
        switch ((string)$action) {
            case 'advertising_stopped':
                return ['advertising'];

            case 'personal_data_deleted':
            case 'personal_data_retained':
                return ['personal_data'];

            case 'all_completed':
                return ['advertising', 'personal_data'];

            default:
                return [];
        }
    }
}

if (!function_exists('mriConsentBuildCaseV2')) {
    function mriConsentBuildCaseV2(
        array $consent,
        array $records
    ) {
        $id = (string)($consent['evidence_id'] ?? '');
        $revocations = [];
        $executions = [];

        foreach ($records as $record) {
            if (
                (string)($record['target_evidence_id'] ?? '')
                !== $id
            ) {
                continue;
            }

            if (($record['event_type'] ?? '') === 'revocation') {
                $revocations[] = $record;
            } elseif (
                ($record['event_type'] ?? '')
                === 'revocation_execution'
            ) {
                $executions[] = $record;
            }
        }

        usort(
            $revocations,
            static function ($a, $b) {
                return strcmp(
                    (string)(
                        $a['request_received_at']
                        ?? $a['recorded_at']
                        ?? ''
                    ),
                    (string)(
                        $b['request_received_at']
                        ?? $b['recorded_at']
                        ?? ''
                    )
                );
            }
        );

        usort(
            $executions,
            static function ($a, $b) {
                return strcmp(
                    (string)($a['completed_at'] ?? ''),
                    (string)($b['completed_at'] ?? '')
                );
            }
        );

        $pdRevoked = false;
        $adRevoked = false;
        $pending = [];

        foreach ($revocations as $revocation) {
            $scopes = array_values(
                array_intersect(
                    (array)($revocation['revoked_scopes'] ?? []),
                    ['personal_data', 'advertising']
                )
            );

            $pdRevoked = $pdRevoked
                || in_array('personal_data', $scopes, true);
            $adRevoked = $adRevoked
                || in_array('advertising', $scopes, true);

            $covered = [];
            $revocationId =
                (string)($revocation['event_id'] ?? '');

            foreach ($executions as $execution) {
                if (
                    (string)(
                        $execution['target_revocation_id'] ?? ''
                    ) !== $revocationId
                ) {
                    continue;
                }

                $covered = array_unique(
                    array_merge(
                        $covered,
                        mriConsentExecutionScopesV2(
                            $execution['completion_action'] ?? ''
                        )
                    )
                );
            }

            $pendingScopes = array_values(
                array_diff($scopes, $covered)
            );

            if (!empty($pendingScopes)) {
                $pending[] = [
                    'revocation' => $revocation,
                    'pending_scopes' => $pendingScopes,
                ];
            }
        }

        $consent['_revocations'] = $revocations;
        $consent['_executions'] = $executions;
        $consent['_personal_data_revoked'] = $pdRevoked;
        $consent['_advertising_revoked'] = $adRevoked;
        $consent['_pending_revocations'] = $pending;

        return $consent;
    }
}

if (!function_exists('mriFindConsentCasesV2')) {
    function mriFindConsentCasesV2($query, $limit = 100)
    {
        $query = trim((string)$query);

        if ($query === '') {
            return [];
        }

        $records = mriConsentReadAllV2();
        $phoneHash = mriConsentLookupHash('phone', $query);
        $emailHash = mriConsentLookupHash('email', $query);
        $matchedIds = [];

        foreach ($records as $record) {
            if (
                !mriConsentQueryMatchV2(
                    $record,
                    $query,
                    $phoneHash,
                    $emailHash
                )
            ) {
                continue;
            }

            $id = ($record['event_type'] ?? '') === 'consent'
                ? (string)($record['evidence_id'] ?? '')
                : (string)($record['target_evidence_id'] ?? '');

            if ($id !== '') {
                $matchedIds[$id] = true;
            }
        }

        $cases = [];

        foreach ($records as $record) {
            if (($record['event_type'] ?? '') !== 'consent') {
                continue;
            }

            $id = (string)($record['evidence_id'] ?? '');

            if ($id === '' || empty($matchedIds[$id])) {
                continue;
            }

            $cases[] = mriConsentBuildCaseV2(
                $record,
                $records
            );

            if (count($cases) >= $limit) {
                break;
            }
        }

        usort(
            $cases,
            static function ($a, $b) {
                return strcmp(
                    (string)($b['submitted_at'] ?? ''),
                    (string)($a['submitted_at'] ?? '')
                );
            }
        );

        return $cases;
    }
}

if (!function_exists('mriGetConsentCaseV2')) {
    function mriGetConsentCaseV2($evidenceId)
    {
        $cases = mriFindConsentCasesV2(
            (string)$evidenceId,
            1
        );

        return $cases[0] ?? null;
    }
}

if (!function_exists('mriRecordConsentRevocationV2')) {
    function mriRecordConsentRevocationV2(
        array $case,
        array $scopes,
        $requestReceivedAt,
        $requestChannel,
        $note
    ) {
        $scopes = array_values(
            array_unique(
                array_intersect(
                    ['personal_data', 'advertising'],
                    $scopes
                )
            )
        );

        if (!empty($case['_personal_data_revoked'])) {
            $scopes = array_values(
                array_diff($scopes, ['personal_data'])
            );
        }

        if (
            !empty($case['_advertising_revoked'])
            || empty($case['advertising_consent'])
        ) {
            $scopes = array_values(
                array_diff($scopes, ['advertising'])
            );
        }

        if (empty($scopes)) {
            return false;
        }

        $received = mriConsentParseDateV2(
            $requestReceivedAt
        );
        $recorded = mriConsentNowV2();

        $record = array_merge(
            [
                'event_type' => 'revocation',
                'event_id' => mriConsentEvidenceId(),
                'target_evidence_id' =>
                    (string)($case['evidence_id'] ?? ''),
                'request_received_at' =>
                    $received->format(DateTimeInterface::ATOM),
                'recorded_at' =>
                    $recorded->format(DateTimeInterface::ATOM),
                'revoked_scopes' => $scopes,
                'request_channel' =>
                    mriConsentLimitText($requestChannel, 100),
                'note' => mriConsentLimitText($note, 2000),
                'phone_lookup_hmac' =>
                    (string)($case['phone_lookup_hmac'] ?? ''),
                'email_lookup_hmac' =>
                    (string)($case['email_lookup_hmac'] ?? ''),
                'phone_masked' =>
                    (string)($case['phone_masked'] ?? ''),
                'email_masked' =>
                    (string)($case['email_masked'] ?? ''),
                'deletion_due_at' =>
                    in_array('personal_data', $scopes, true)
                        ? $received
                            ->modify('+30 days')
                            ->format(DateTimeInterface::ATOM)
                        : '',
            ],
            mriConsentAdminIdentityV2()
        );

        return mriWriteConsentEvidence($record)
            ? $record
            : false;
    }
}

if (!function_exists('mriRecordRevocationExecutionV2')) {
    function mriRecordRevocationExecutionV2(
        array $case,
        $revocationId,
        $completionAction,
        $note
    ) {
        $allowed = [
            'advertising_stopped',
            'personal_data_deleted',
            'personal_data_retained',
            'all_completed',
        ];

        if (!in_array($completionAction, $allowed, true)) {
            return false;
        }

        $target = null;

        foreach ((array)($case['_revocations'] ?? []) as $item) {
            if (
                hash_equals(
                    (string)($item['event_id'] ?? ''),
                    (string)$revocationId
                )
            ) {
                $target = $item;
                break;
            }
        }

        if (!$target) {
            return false;
        }

        $record = array_merge(
            [
                'event_type' => 'revocation_execution',
                'event_id' => mriConsentEvidenceId(),
                'target_evidence_id' =>
                    (string)($case['evidence_id'] ?? ''),
                'target_revocation_id' =>
                    (string)($target['event_id'] ?? ''),
                'completed_at' =>
                    mriConsentNowV2()->format(
                        DateTimeInterface::ATOM
                    ),
                'completion_action' => $completionAction,
                'note' => mriConsentLimitText($note, 2000),
                'phone_lookup_hmac' =>
                    (string)($case['phone_lookup_hmac'] ?? ''),
                'email_lookup_hmac' =>
                    (string)($case['email_lookup_hmac'] ?? ''),
                'phone_masked' =>
                    (string)($case['phone_masked'] ?? ''),
                'email_masked' =>
                    (string)($case['email_masked'] ?? ''),
            ],
            mriConsentAdminIdentityV2()
        );

        return mriWriteConsentEvidence($record)
            ? $record
            : false;
    }
}
