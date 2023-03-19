<?php

namespace App\Http\Controllers\ManagementPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\ManagementPortal\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Orders;
use Datatables;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CommonRepository;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user, CommonRepository $common) {
        $this->user = $user;
        $this->common = $common;
    }
    
    /**
     * Create User.
     *
     */
    public function createUser(Request $request) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->user->createUser($request->all());
            if ($data && $data == 'EmailExists') {
                return redirect(route('createUser'))->with('error','This Email is already registered.');
            } else if ($data == 'Created') {
                return redirect(route('listUser'))->with('success','User created successfully.');
            } else {
                return redirect(route('listUser'))->with('error','Something went wrong, please try again!');
            }
        }
        return View('admin.user.create');
    }

    /**
     * Login.
     *
     */
    public function login(Request $request) {
        if (Auth::check()) {
            return redirect(route('adminDashboard'));
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect(route('adminDashboard'));
            } else {
                return redirect(route('login'))->with('error','Your username and password does not match, please try again!');
            }
        }
        return View('admin.login');
    }

    /**
     * Logout.
     *
     */
    public function logout() {
        Auth::logout();
        return redirect(route('login'));
    }

    /**
     * List User.
     *
     */
    public function listUser() {
        if(request()->ajax()) {
            return datatables()->of(User::select('*'))
            ->addColumn('action', function($row){
                return  '<a href="'. url('/admin/edit_user/'.$row['id']).'"><button type="button"
                            class="btn btn-primary btn-info shadow-sm btn--sm mr-2 acceptid"
                            data-toggle="tooltip" data-placement="left" >Edit
                        </button></a>
                        <button type="button" class="btn btn-danger shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            onclick="deleteFunc('.$row['id'].')">Delete
                        </button>';
            })
            ->editColumn('is_admin', function ($row){
                if ($row['is_admin'] == 0) {
                    return 'Staff Member ';
                } elseif ($row['is_admin'] == 1) {
                    return 'Admin';
                }
                return '';
            })
            ->make(true);
        }
        return View('admin.user.list');
    }

    /**
     * Edit User View.
     *
     */
    public function editUser($id) {
        if (Auth::user()->is_admin == 1 || Auth::user()->id == $id) {
            $userData = User::find($id);
            return View('admin.user.edit')->with('user',$userData);
        }
        return redirect(route('adminDashboard'));
    }

    /**
     * Update User.
     *
     */
    public function updateUser(Request $request) {
        if (Auth::user()->is_admin == 1 || Auth::user()->id == $request->id) {
            $data = $this->user->updateUser($request->all());
            if ($data && $data == 'EmailExists') {
                return redirect('admin/edit_user/'.$request->id)->with('error','This Email is already registered.');
            } else if ($data == 'Updated') {
                return redirect(route('listUser'))->with('success','User updated successfully.');
            } else {
                return redirect(route('listUser'))->with('error','Something went wrong, please try again!');
            }
        }
        return redirect(route('adminDashboard'));
    }

    /**
     * Delete User.
     *
     */
    public function deleteUser(Request $request) {
        $data = $this->user->deleteUser($request->all());
        return Response()->json($data);
    }

    /**
     * Forgot Password.
     *
     */
    public function forgotPassword(Request $request) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $request->email;
            $user  = $this->user->findByEmail($email);
            if (!$user) {
                return redirect(route('forgotPassword'))->with('error','Email not found!');
            }
            $urlPath = $this->user->getResetPasswordUrl($request->all());

            $details['link'] = $urlPath;
            $name            = $user->name;
            $to       = $email;
            $from     = config('ndis.email.from_email');
            $subject  = 'Forgot Password';
            $body     = view('forgotpassword_mail')->with(['link' => $details['link'],'name' => $name])->render();
            try {
                $send = $this->common->sendEmail($to, $from, $subject, $body);
            }catch (\Exception $exception){
                \Log::info($exception->getMessage());
            }

            return redirect(route('forgotPassword'))->with('success','Reset Password link sent successfully.');
        }
        return View('admin.forgot_password');
    }

    /**
     * Reset Password.
     *
     */
    public function resetPassword(Request $request, $tokenWithEmail) {
        $tokenWithEmail = explode('/', base64_decode($tokenWithEmail));
        $token = $email = '';
        if (isset($tokenWithEmail[0])) {
            $token = $tokenWithEmail[0];
        }
        if (isset($tokenWithEmail[1])) {
            $email = $tokenWithEmail[1];
        }
        
        if ($token && $email) {
            $resPass = $this->user->getpasswordReset($token);
            if (isset($resPass) && $resPass) {
                $expire = strtotime($resPass->created_at.' + 1 days');
                $today  = strtotime("now");
            } else {
                return redirect(route('login'))->with('error','Reset Password token is invalid');
            }

            if ($today >= $expire) {
                return redirect(route('login'))->with('error','Reset Password token is expired');
            } else {
                return View('admin.reset_password')->with(['email' => $email, 'token' => $token]);
            }
        }
        return redirect(route('login'))->with('error','Something went wrong!');
    }

    /**
     * Reset Password.
     *
     */
    public function postResetPassword(Request $request) {
        $token = $request->token;
        $email = $request->email;
        
        if ($token && $email) {
            $resPass = $this->user->getpasswordReset($token);
            if (isset($resPass) && $resPass) {
                $expire = strtotime($resPass->created_at.' + 1 days');
                $today  = strtotime("now");
            } else {
                return redirect(route('login'))->with('error','Reset Password token is invalid');
            }

            if ($today >= $expire) {
                return redirect(route('login'))->with('error','Reset Password token is expired');
            } else {
                $userModel = User::where('email',$email)->first();
                if (!$userModel) {
                    return redirect(route('login'))->with('error','Something went wrong!');
                }
                $userModel->password = $request->password;
                $this->user->deletePasswordToken($token);
                $userModel->save();
                if ($userModel->save()) {
                    return redirect(route('login'))->with('success','Reset Password successfully.');
                }
            }
        }
        return redirect(route('login'))->with('error','Something went wrong!');
    }

    /**
     * Dashboard.
     *
     */
    public function dashboard() {
        $order['total_orders']  = Orders::count();
        $order['paid_orders']   = Orders::where('order_status',config('ndis.orderStatus.Paid'))->count();
        $order['error_orders']  = Orders::where('order_status',config('ndis.orderStatus.Error'))->count();
        $order['active_orders'] = Orders::whereIn('order_status',[config('ndis.orderStatus.Submited'),config('ndis.orderStatus.Resubmited')])->count();
        return View('admin.dashboard')->with(['order' => $order]);
    }

    /**
     * Show 2FA Setting form
     */
    public function show2faForm(Request $request){
        $user = Auth::user();
        $google2fa_url = "";
        $secret_key = "";
        
        if($user->google2fa_secret){
            /*$google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'MyNotePaper Demo',
                $user->email,
                $user->loginSecurity->google2fa_secret
            );*/
            $secret_key = $user->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );

        return view('auth.2fa_settings')->with('data', $data);
    }

    /**
     * Generate 2FA secret key
     */
    public function generate2faSecret(Request $request) {
        $user = Auth::user();
        // Initialise the 2FA class
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        // Add the secret key to the registration data
        
        $userFind = User::find($user->id);
        $userFind->google2fa_secret = $google2fa->generateSecretKey();
        $userFind->save();

        return redirect('/2fa')->with('success',"Secret key is generated.");
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request) {
        $user = Auth::user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

        if($valid){
            $user->google2fa_enable = 1;
            $user->save();
            return redirect('2fa')->with('success',"2FA is enabled successfully.");
        }else{
            return redirect('2fa')->with('error',"Invalid verification Code, Please try again.");
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your password does not matches with your account password. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::user();
        $user->google2fa_enable = 0;
        $user->save();
        return redirect('/2fa')->with('success',"2FA is now disabled.");
    }

    /**
     * verify 2FA
     */
    public function verify2fa(){
        return view('auth.2fa_verify');
    }

}