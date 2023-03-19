<?php

namespace App\Repositories;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Templates;
use Illuminate\Http\Response;
use App\Models\JwkData;
use Jose\Component\KeyManagement\JWKFactory;
use CoderCat\JWKToPEM\JWKConverter;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;
use App\Models\DeviceAuthentication;
use App\Models\Logs;
use Carbon\Carbon;
use App\Events\HistoryForSentEmails;
use Exception;
class CommonRepository
{

	/**
	 * Create Jwk.
	 *
	 */
	public function createJwk() {
		$allJWK = JWKFactory::createRSAKey(
                2048,
                [
                    'alg' => 'RS256',
                    'use' => 'sig',
                    "kid" => config('ndis.activate.keyId'),
                ]);
        $requiredJWK = $allJWK->toPublic()->jsonSerialize();

        $jwk = json_encode($requiredJWK);

        //public key generation
        $jwkConverter = new JWKConverter();
        $publicKey = $jwkConverter->toPEM($requiredJWK);

		$jwk_private = $allJWK->all();
		$token = $this->createJwtToken($jwk_private);

		$updateJwkData = JwkData::first();
		if ($updateJwkData) {
			$updateJwkData->jwk = $this->encrypt_decrypt($jwk);
			$updateJwkData->jwk_private = $this->encrypt_decrypt(json_encode($jwk_private));
			$updateJwkData->jwt_token = $this->encrypt_decrypt($token);
			$updateJwkData->public_key = $this->encrypt_decrypt($publicKey);
			$updateJwkData->save();
		} else {
			$createJwkData = new JwkData();
			$createJwkData->jwk = $this->encrypt_decrypt($jwk);
			$createJwkData->jwk_private = $this->encrypt_decrypt(json_encode($jwk_private));
			$createJwkData->jwt_token = $this->encrypt_decrypt($token);
			$createJwkData->public_key = $this->encrypt_decrypt($publicKey);
			$createJwkData->save();
		}
		return $jwk;
	}

	/**
	 * Create Jwt Token.
	 *
	 * @param array $jwkPrivate
	 * @return string
	 */
	public function createJwtToken($jwkPrivate) {
		$current_time = date('Y-m-d H:i:s');
        $exp_time = strtotime($current_time.'+5 years');
        $cur_time = strtotime($current_time);
        $jwk = new JWK($jwkPrivate);
       
        $algorithmManager = new AlgorithmManager([
            new RS256(),
        ]);

        $jwsBuilder = new JWSBuilder($algorithmManager);
        $payload = json_encode([
            'iat' => $cur_time,
            'exp' => $exp_time,
            'iss' => config('ndis.activate.organizationId'),
            'aud' => config('ndis.activate.aud'),
            'token.aud' => config('ndis.activate.token_aud'),
            'sub' => config('ndis.activate.keyId')
        ]);
        $jws = $jwsBuilder
            ->create()                               // We want to create a new JWS
            ->withPayload($payload)                  // We set the payload
            ->addSignature($jwk, ['alg' => 'RS256','kid' => config('ndis.activate.keyId'),'typ' => 'JWT'])
            ->build();
        $serializer = new CompactSerializer(); // The serializer
        $token = $serializer->serialize($jws, 0);
        return $token;
	}

	/**
	 * Generate 36 character UUID.
	 *
	 * @return string
	 */
	public function uuid() {
	    $data = $data ?? random_bytes(16);
	    assert(strlen($data) == 16);
	    // Set version to 0100
	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
	    // Set bits 6-7 to 10
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	/**
	 * Encrypt and Decrpt Data.
	 *
	 * @param string $string
	 * @param string $action
	 * @return string
	 */
	public static function encrypt_decrypt($string, $action = 'encrypt') {
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = config('ndis.encrypt_decrypt_secret_key'); // user define private key
	    $secret_iv = config('ndis.secret_iv'); // user define secret key
	    $key = hash('sha256', $secret_key);
	    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
	    if ($action == 'encrypt') {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if ($action == 'decrypt') {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	}

	/**
	 * Check Access Token Expiry
	 *
	 * @return boolean
	 */
	public function checkAccessTokenExpiry() {
	    $deviceAuth = DeviceAuthentication::get()->first();
	    if ($deviceAuth) {
	    	if (time() >= strtotime($deviceAuth->token_expiry)) {
	    		return true;
	    	} else {
	    		return false;
	    	}
	    } else {
	    	return true;
	    }
	    return true;
	}

	/**
	 * make a Combinations
	 *
	 * @return array
	 */
	public function combinations( $array, $from = 0, $length = false ) {
        if ( $length === false )
        {
            $length = count( $array );
        }

        if ( $length == $from )
        {
            return array('');
        } else {
            $result = array();

            foreach( $array[$from] as $x ) 
            {
                foreach( $this->combinations( $array, $from+1, $length ) as $tail )
                {
                    $result[] = trim("$x,$tail");
                }
            }
            return $result;
        }
    }


    /**
	 * Store  Logs.
	 *
	 * @param array $requestData
	 * @return mix
	 */
	public function storeLogs($requestData) {
		if (isset($requestData['id']) && $requestData['id']) {
			$exitsLog = Logs::where('id',$requestData['id'])->first();
			if ($exitsLog) {
				$logsObj = 	$exitsLog;
			} else {
				$logsObj = new Logs();	
			}
		} else {
			$logsObj = new Logs();
		}

		$logsObj->name 		= $requestData['name'];
		$logsObj->url 		= $requestData['url'];
		$logsObj->headers 	= $requestData['headers'];
		$logsObj->method 	= $requestData['method'];
		if (isset($requestData['payload'])) {
			$logsObj->payload 	= $requestData['payload'];
		}
		if (isset($requestData['response'])) {
			$logsObj->response 	= $requestData['response'];
		}
		if ($logsObj->save()) {
			return $logsObj->id;
		}
		return false;
	}

	/**
     * Delete Logs.
     *
     */
    public function deleteLogsCron() {
    	$days = config('ndis.deleteLogDays');
        $data = Logs::where('created_at', '<', Carbon::now()->subDays($days)->toDateTimeString())->delete();
        return 'Delete Logs Cron Run Successfully.';
    }

    /**
	 * Send Email.
	 *
	 * @param string $to
	 * @param string $from
	 * @param string $subject
	 * @param string $body
	 * @return boolean
	 */
	// public function sendEmail($to, $from, $subject, $body, $attachment = '', $cc = '') {
		
	// 	$email = new \SendGrid\Mail\Mail();
	// 	$email->setFrom($from, config('ndis.email.sender'));
	// 	$email->setSubject($subject);
	// 	$email->addTo($to, "");
	// 	if ($cc) {
	// 		$email->addCc($cc, "");
	// 	}
	// 	$email->addContent("text/html", $body);
		
	// 	$sendgrid = new \SendGrid(config('ndis.email.sendgrid_key'));
	// 	$response = $sendgrid->send($email);
	// 	if ($response->statusCode() == Response::HTTP_ACCEPTED || $response->statusCode() == Response::HTTP_OK) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }
	public function sendEmail($to, $from, $subject, $body, $attachment = '', $cc = '', $bcc = '', $details = '')
	{

		$email = new \SendGrid\Mail\Mail();
		$email->setFrom($from, config('ndis.email.sender'));
		$email->setSubject($subject);
		$email->addTo($to, "");
		if ($cc) {
			$email->addCc($cc, "");
		}
		if ($bcc) {
			$email->addBcc($bcc, "");
		}
		$email->addContent("text/html", $body);
		if ($attachment) {
			$arrContextOptions = [
				"ssl"               => [
					"verify_peer"      => false,
					"verify_peer_name" => false,
				]
			];
			$data         = file_get_contents($attachment, false, stream_context_create($arrContextOptions));
			$file_encoded = base64_encode($data);
			$email->addAttachment($file_encoded, "application/pdf", "invoice_" . $details['invoice_no'] . ".pdf", "attachment");
		}
		$sendgrid = new \SendGrid(config('ndis.email.sendgrid_key'));
		$response = $sendgrid->send($email);
		if ($response->statusCode() == Response::HTTP_ACCEPTED || $response->statusCode() == Response::HTTP_OK) {
			event(new HistoryForSentEmails($email,$details['order_number']));
			return true;
		} else {	
			return false;
		}
	}
}
