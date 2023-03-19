<?php 
namespace App\Repositories\ManagementPortal;

use App\Models\JwkData;
use Illuminate\Http\Response;
use App\Repositories\CommonRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserRepository
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonRepository $common) {
        $this->common = $common;
    }

	/**
     * Create User.
     *
     */
    public function createUser($requestData) {
        $userEmailExists = User::where('email',$requestData['email'])->first();
        if ($userEmailExists) {
            return 'EmailExists';
        }
        $user = new User();
        $user->name = $requestData['username'];
        $user->email = $requestData['email'];
        $user->password = $requestData['password'];
        if (isset($requestData['role']) && $requestData['role']) {
            $user->is_admin = $requestData['role'];
        }
        if($user->save()) {
            return 'Created';
        }
        return false;
    }

    /**
     * Update User.
     *
     */
    public function updateUser($requestData) {
        $userEmailExists = User::where('id','!=',$requestData['id'])->where('email',$requestData['email'])->first();
        if ($userEmailExists) {
            return 'EmailExists';
        }
        $user = User::where('id',$requestData['id'])->first();
        if ($user) {
            $user->name = $requestData['username'];
            $user->email = $requestData['email'];
            if (isset($requestData['password']) && $requestData['password']) {
                $user->password = $requestData['password'];
            }
            if (isset($requestData['role'])) {
                $user->is_admin = $requestData['role'];
            }
            if($user->save()) {
                return 'Updated';
            }
        }
        return false;
    }

    /**
     * Find Email from users table.
     *
     * @param string $email
     * @return object
     */
    public function findByEmail($email) {
        $data = User::where('email', $email)->first();
        return $data;
    }

    /**
     * Delete User.
     *
     */
    public function deleteUser($requestData) {
        if (Auth::check() && Auth::user()->id != $requestData['id']) {
            return User::where('id',$requestData['id'])->delete();
        }
        return false;
    }

    /**
     * Get Reset Password Url.
     *
     * @param array $requestData
     * @return string
     */
    public function getResetPasswordUrl($requestData) {
        $email          = $requestData['email'];
        $token          = $this->saveToken($email);
        $tokenWithEmail = base64_encode($token.'/'.$email);
        
        $urlPath = url('admin/reset_password/'.$tokenWithEmail);
        return $urlPath;
    }

    /**
     * Save Token.
     *
     * @param string $email
     * @return string
     */
    public function saveToken($email) {
        $token = hash_hmac('sha256', Str::random(40), 'hashKey');
        $table = DB::table('password_resets')->insert([
                'email'      => $email,
                'token'      => $token,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        return $token;
    }

    /**
     * Get Token Data.
     *
     * @param string $token
     * @return object
     */
    public function getpasswordReset($token) {
        return DB::table('password_resets')->where('token', $token)->first();
    }

    
    /**
     * Delete Token.
     *
     * @param string $token
     */
    public function deletePasswordToken($token) {
        DB::table('password_resets')->where('token', $token)->delete();
    }
}