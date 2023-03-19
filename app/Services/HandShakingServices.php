<?php

	namespace App\Services;
	use Illuminate\Support\Facades\Log;
    use Jose\Component\KeyManagement\JWKFactory;
    use CoderCat\JWKToPEM\JWKConverter;
    use Jose\Component\Core\JWK;
    use Jose\Component\Signature\Algorithm\RS256;
    use Jose\Component\Core\AlgorithmManager;
    use Jose\Component\Signature\JWSBuilder;
    use Jose\Component\Signature\Serializer\CompactSerializer;

    class HandShakingServices
	{
        public static function activateDevice()
        {
            $allJWK = JWKFactory::createRSAKey(
                2048,
                [
                    'alg' => 'RS256',
                    'use' => 'sig',
                    "kid" => config('ndis.activate.keyId'),
                ]);
            $requiredJWK = $allJWK->toPublic()->jsonSerialize();
            Log::info(json_encode($requiredJWK));
//          //public key generation
            $jwkConverter = new JWKConverter();
            $publicKey = $jwkConverter->toPEM($requiredJWK);
            Log::info($publicKey);
            //token generation
            $algorithmManager = new AlgorithmManager([
                new RS256(),
            ]);
            $time = time(); // The current time
            $jwk = new JWK($allJWK->all());
            Log::info((string)$jwk->all());
            $jwsBuilder = new JWSBuilder($algorithmManager);
            $payload = json_encode([
                'iat' => 1614689996,
                'exp' => 1624689996,
                'iss' => '5529384008',
                'aud' => 'https://proda.humanservices.gov.au',
                'token.aud' => 'https://www.ndis.gov.au/',
                'sub' => 'BettercareNDISDevice'
            ]);
            $jws = $jwsBuilder
                ->create()                               // We want to create a new JWS
                ->withPayload($payload)                  // We set the payload
                ->addSignature($jwk, ['alg' => 'RS256','kid' => 'BettercareNDISDevice','typ' => 'JWT'])
                ->build();
            $serializer = new CompactSerializer(); // The serializer
            $token = $serializer->serialize($jws, 0);
            Log::info($token);
//            $jws = Build::jws()
//            ->exp(1624689996)
//            ->iat(1614689996)
//            ->iss('5529384008')
//            ->alg('RS256')
//            ->aud('https://proda.humanservices.gov.au')
//            ->aud('https://www.ndis.gov.au/')
//            ->sub('BettercareNDISDevice')
//            ->header('typ','JWT')
//                ->header('kid','BettercareNDISDevice')
//                ->header('alg','RS256')
//                ->sign($jwk);
//            Log::info(json_encode($jws));
        }
	}
