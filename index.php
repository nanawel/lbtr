<?php

/**
 * Decode URL-safe base64 encoded string
 *
 * @see https://en.wikipedia.org/wiki/Base64#RFC_4648
 *
 * @param string $input
 * @return string
 */
function base64_url_decode(string $input): string {
    if (false === ($string = base64_decode(strtr($input, '-_.', '+/=')))) {
        throw new \InvalidArgumentException('Invalid base64url string.');
    }

    return $string;
}

function json_prettify(string $input): string {
    return json_encode(json_decode($input, null, 512, JSON_THROW_ON_ERROR), JSON_PRETTY_PRINT);
}

$decoderAliases = [
    'b64ud' => 'base64_url_decode',
    'b64d' => 'base64_decode',
    'zd' => 'zlib_decode',
    'gzi' => 'gzinflate',
    'jp' => 'json_prettify',
    'p' => 'print',
    'e' => 'echo',
    'n' => 'none',
];

foreach ($_GET as $p => $v) {
    switch ($p) {
        case 'header':
        case 'h':
            if (is_array($v)) {
                foreach ($v as $header => $value) {
                    if (is_array($value)) {
                        foreach ($value as $subValue) {
                            header("$header: $subValue", false);
                        }
                    } else {
                        header("$header: $value");
                    }
                }
            } else {
                error_log('Invalid header definition, must be an array.');
            }
            break;
        
        case 'body':
        case 'b':
            $body = $v;
            break;
        
        case 'dec':
        case 'd':
            foreach (explode(',', $v) as $decoder) {
                $decoder = $decoderAliases[$decoder] ?? $decoder;
                switch ($decoder) {
                    case 'base64_url_decode':
                    case 'base64_decode':
                    case 'zlib_decode':
                    case 'gzinflate':
                    case 'json_prettify':
                    case 'print':
                    case 'echo':
                    case 'none':
                        $bodyDecoders[] = $decoder;
                        break;
                    
                    default:
                        error_log("Unsupported body decoder: $decoder. Ignoring.");
                }
            }
            break;
        
        default:
           error_log("Unsupported param: $p. Ignoring.");
    }
}

if (!isset($bodyDecoders)) {
    // Default decoder
    $bodyDecoders = ['base64_url_decode'];
}

if (isset($body)) {
    die(array_reduce($bodyDecoders, function($carry, $decoderCallable) {
        try {
            if (in_array($decoderCallable, ['echo', 'print', 'none'])) {
                return $carry;
            }
            return $decoderCallable($carry);
        } catch (\Throwable $e) {
            file_put_contents('php://stderr', "Unable to decode body with $decoderCallable: {$e->getMessage()}\n");
            error_log("Unable to decode body with $decoderCallable: {$e->getMessage()}");
        }
    }, $body));
}