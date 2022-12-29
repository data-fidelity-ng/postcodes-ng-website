<?php

namespace App\Http\Helpers;

use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use DateTimeImmutable;

class AjaxHelper {
    public static function generateWebJWT() {
        return static::buildJWT('http://www.postcodes.ng', 'http://www.postcodes.ng/api', 3600);
    }

    public static function generateAPIJWT() {
        return static::buildJWT('http://www.postcodes.ng/api', 'http://www.postcodes.ng/api', 20);
    }

    public static function validateJWT($jwtTokenString, $type) {
        $jwtSecret = config('auth.jwt_secret');

        $token = (new Parser(new JoseEncoder()))->parse((string) $jwtTokenString);

        # ensure the jwt token isn't expired
        $validator = new Validator(); // It will use the current time to validate (iat, nbf and exp)

        # verify the iat, nbf, and exp
        // if (! $validator->validate($token, new StrictValidAt())) {
        //     return false;
        // }

        # verify the jwt signature
        $signer = new Sha256();
        if (! $validator->validate($token, new SignedWith($signer, InMemory::plainText($jwtSecret)))) {
            return false;
        }

        return true;
    }

    public static function formatAjaxResponse($response) {
        $originalContent = $response->getOriginalContent();

        if (is_array($originalContent) && array_key_exists('error', $originalContent)) {
            $message = $response->status() != 200 ? 'An unexpected error occurred' : $originalContent ['error'];
            return response()->json(
                    [
                            'status' => 'error',
                            'message' => $message,
                            'response' => NULL
                    ], $response->status() === 200 ? 400 : $response->status());
        } else if (is_array($originalContent)) {
            return response()->json(
                    [
                            'status' => 'success',
                            'message' => NULL,
                            'response' => $originalContent
                    ], 200);
        } else {
            return $response;
        }
    }

    private static function buildJWT($issuer, $audience, $expireInSeconds) {
        $signer = new Sha256();
        $now   = new DateTimeImmutable();

        $jwtSecret = config('auth.jwt_secret');
        $jwtId = config('auth.jwt_id');

        $chainedFormatter = ChainedFormatter::default();
        $builder = new Builder(new JoseEncoder(), $chainedFormatter);

        $token = $builder->issuedBy($issuer) // Configures the issuer (iss claim)
                                ->permittedFor($audience) // Configures the audience (aud claim)
                                ->identifiedBy($jwtId, true) // Configures the id (jti claim), replicating as a header item
                                ->issuedAt($now) // Configures the time that the token was issue (iat claim)
                                ->canOnlyBeUsedAfter($now) // Configures the time that the token can be used (nbf claim)
                                ->expiresAt($now->modify('+' . strval($expireInSeconds) . ' second')) // Configures the expiration time of the token (exp claim)
                                ->getToken($signer, InMemory::plainText($jwtSecret)) // Retrieves the generated token
                                ->toString();
        
        return $token;
    }
}
