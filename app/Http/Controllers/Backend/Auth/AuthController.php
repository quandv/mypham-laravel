<?php

namespace App\Http\Controllers\Backend\Auth;
use Validator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Lang;
use Mail;
use Illuminate\Mail\Mailer;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Contracts\Auth\PasswordBroker;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // lỗi xuất hiện ở dòng này :D
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    //Custom for throttleslogins
    public function username()
    {
        return 'email';
    }
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|email', 'password' => 'required|min:6',
        ],[
            'email.required'=> 'Bạn chưa nhập email',
            'email.email'=>'Email không đúng định dạng',
            'password.required'=> 'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu phải có ít nhất 6 ký tự',

        ]);
    }
    public function index()
    {
        if (Auth::check()) {
            if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
                return redirect()->route('admin.order.all');
            }
            if (access()->hasPermission('dashboard')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('admin.welcome');

        }else{
            return redirect()->route('admin.login');
        }
    }
    public function getLogin(){
        return view('backend.auth.login');
    }
    public function postLogin(Request $request){
        //$this->clearLoginAttempts($request);
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $email = $request->input('email');
        $password = $request->input('password');
        if(Auth::attempt(['email'=>$email,'password'=>$password],$request->has('remember_login'))){
                
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);

                //return view('dashboard',['user'=>$data]);
                if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
                    return redirect()->route('admin.order.all');
                }

                if (access()->hasPermission('dashboard')) {
                    return redirect()->route('admin.dashboard');
                } 
              
                return redirect()->route('admin.welcome');
        }
        
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
       
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /*return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
    }
    protected function hasTooManyLoginAttempts(Request $request){
       // $lockoutTime = 10 / 60;    //lockout after 10 seconds (setting is in minutes hence devision by 60 for setting the time in seconds)
        $lockoutTime = 60/60;
        $maxLoginAttempts = 5;    //lockout after 5 attempts

        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
        );
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => 'Email hoặc mật khẩu không đúng',//Lang::get('auth.failed'),
            ]);
    }
   /* public function validateLogin(Request $request)
    {
        $messages = [
            'exists' => 'Your account is not yet active.',
        ];

        $this->validate($request, [
            $this->username() => 'required|exists:users,email,active,1', 
            'password'        => 'required',
        ], $messages);
    }
*/

    public function getForgot(){
        if (Auth::check()) {
            if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
                return redirect()->route('admin.order.all');
            }
            if (access()->hasPermission('dashboard')) {
                return redirect()->route('admin.dashboard');
            }

        }else{
            return view('backend.auth.forgot');
        }
    }

    /**
    * Send a reset link to the given user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function postForgot(Request $request/*, PasswordBroker $passwords*/)
   {
        $rules = [
            'email'      =>'required|email'
        ];
        $messages = [
            'email.required'  =>'Bạn chưa nhập email',
            'email.email'     =>'Định dạng email không đúng'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);            
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{            
            $response = Password::sendResetLink($request->only('email'));

            switch ($response) {
                case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', 'Yêu cầu của bạn đã được gửi, vui lòng kiểm tra email để tiếp tục.');

                case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => 'Chúng tôi không thể tìm thấy email này, vui lòng kiểm tra lại.']);
            }
        }
   }

    public function getResetPass(Request $request, $token){
        if (Auth::check()) {
            if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
                return redirect()->route('admin.order.all');
            }
            if (access()->hasPermission('dashboard')) {
                return redirect()->route('admin.dashboard');
            }
        }else{
            if($token != ''){
                $data = array(
                        'token' => $token
                    );
                return view('backend.auth.reset_password', $data);
            }else{
                return view('backend.auth.forgot');
            }
        }
    }

    public function postResetPass(Request $request){
        if (Auth::check()) {
            if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
                return redirect()->route('admin.order.all');
            }
            if (access()->hasPermission('dashboard')) {
                return redirect()->route('admin.dashboard');
            }
        }else{
            $rules = [
                'email'      =>'required|email',
                'password'      =>'required|min:6|confirmed',
                'password_confirmation'      =>'required'
            ];
            $messages = [
                'email.required'  =>'Bạn chưa nhập email',
                'email.email'     =>'Định dạng email không đúng',
                'password.required'  =>'Bạn chưa nhập mật khẩu mới',
                'password.min'     =>'Mật khẩu mới phải có ít nhất 6 ký tự',
                'password_confirmation.required'  =>'Bạn chưa nhập lại mật khẩu mới',
                'password.confirmed'     =>'Mật khẩu mới không trùng khớp',
            ];  
            $validator = Validator::make($request->all(),$rules,$messages);            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $credentials = $request->only(
                    'email', 'password', 'password_confirmation', 'token'
                );
                $response = Password::reset($credentials, function ($user, $password) {
                    $user->password = bcrypt($password);
                    $user->save();
                    Auth::login($user);
                });

                switch ($response) {
                    case Password::PASSWORD_RESET:
                        return view('backend.auth.login', ['status' => 'Cập nhật mật khẩu thành công']);

                    default:
                        return redirect()->back()
                        ->withInput($request->only('email'))
                        ->withErrors(['err_update' => 'Email không hợp lệ (hoặc) Bạn đã sử dụng liên kết này trước đó']);
                }
            }
            
        }
    }
}
