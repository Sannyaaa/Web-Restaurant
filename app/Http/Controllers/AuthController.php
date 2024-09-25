<?php

namespace App\Http\Controllers;

use App\Fonnte;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    use Fonnte;

    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function login_admin(){
        return view('auth.login_admin');
    }

    public function loginProcess(Request $request)
    {
        $phone = $request->phone;
        if(Str::startsWith($phone,'+62'))
        {
            $phone = '0' . substr($phone,3);
        }elseif(Str::startsWith($phone,'62'))
        {
            $phone = '0' . substr($phone,2);
        }

        $request->validate([
            'phone' =>'required|min:11|max:13|exists:users,phone',
            'password' => 'required|string|min:8',
        ]);

        $credentials = [
            'phone' => $phone,
            'password' => $request->password,
            // 'access' => 'yes',
        ];

        //dd($credentials);
        
        $user = User::where('phone',$phone)->first();

        if($user && $user->access == 'no'){
            $random_url = Str::random(64);
            session(['user' => $user ]);
            return redirect()->route('verify',compact('phone','random_url'));
        }

        if(Auth::attempt($credentials,$request->has('remember'))){
            if (Auth::user()->role !== 'user') { // Assuming 'is_admin' is the field in your users table
                return redirect()->route('dashboard'); // Redirect to the admin dashboard
            } else {
                return redirect()->route('order.index'); // Redirect to the orders page for non-admin users
            }
        }else{
            return redirect()->back()->withErrors(['phone' => 'Nomor telpon atau password salah boss']);
        }
    }

    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request){
        // dd($request);
        $phone = $request->phone;

        if(Str::startsWith($phone, '+62')){
            $phone = '0' . substr($phone,3);
        }elseif(Str::startsWith($phone,'62')){
            $phone = '0' . substr($phone,2);
        }

        if ($request->hasFile('avatar')) {
            //$avatarPath = $request->file('avatar')->store('public/avatars');
            // $timestamp = now()->timestamp;
            // $fileName = $timestamp . '.' . $request->file('avatar')->getClientOriginalExtension();
            $image = $request->file('avatar')->store('avatars','public');
        } else {
            $image = 'avatars/default-avatar.png';
        }

        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => "required|string|min:11|max:13|unique:users,phone,{$phone}",
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ] );
        
        if(User::where('phone',$phone)->exists()){
            return redirect()->back()->withErrors();
        }

        $data['otp'] = rand(111111,999999);
        $data['access'] = 'no';
        $data['phone'] = $phone;

        $data['image'] = $image;

        $user = User::create($data);

        //Auth::login($user);
        $random_url = Str::random(64);
        $messages = "ini code OTP anda " . $user->otp;
        $this->send_message($phone,$messages);

        session(['user' => $user ]);

        return redirect()->route('verify', compact('phone','random_url'));
    }

    public function verify(){
        $user = session('user');
        return view('auth.verify',compact('user'));
    }

    public function verifyProcess(Request $request){

        // ambil OTP yang dikirimkan
        $otp = $request->otp;
        $phone = $request->phone;
        $random_url = $request->random_url;
        // cari user berdasarkan OTP
        $user = User::where('otp',$otp)->first();
        // Jika user tidak ditemukan
        if(!$user){
            return redirect()->back()->withErrors(['otp' => 'OTP tidak sesuai']);
        }

        // Jika user ditemukan
        if($user->access == 'no'){
            $user->update([
                'access' => 'yes',
            ]);

            Auth::login($user);

            if($user->role !== 'admin'){
                return redirect()->route('order.index');
            }else{
                return redirect()->route('dashboard');
            }
        }else{
            return redirect()->back()->withErrors('error' , 'Kode suadh kadaluarsa');
        }


        // if($otp == $user->otp){
        //     $user->access = 'yes';
        //     $user->save();
        //     Auth::login($user);
        //     return redirect()->route('dashboard.index');
        // }else{
        //     return redirect()->back()->withErrors(['otp' => 'OTP tidak sesuai']);
        // }
        // if($otp == $user->otp){
        //     $user->access = 'yes';
        //     $user->save();
        //     Auth::login($user);
        //     return redirect()->route('dashboard.index');
        // }else{
        //     return redirect()->back()->withErrors(['otp' => 'OTP tidak sesuai']);
        // }
    }

    public function resend(Request $request){
        // dd($request);
        $phone = $request->phone;

        $user = User::where('phone',$phone)->first();

        $user->update([
            'otp' => rand(111111,999999),
        ]);

        $pesan = "ini OTP anda " . $user->otp;
        $this->send_message($phone,$pesan);
        $random_url = Str::random(64);

        return redirect()->route('verify',compact('phone','random_url'));
    }

    public function forgot_password(){
        return view('auth.forgot-password');
    }

    public function verifyChangePassword(Request $request){
        $request->validate([
            'phone' =>'required|min:11',
        ]);

        $phone = $request->phone;

        $token = rand(111111,999999);

        DB::table('password_token')->insert([
            'phone' => $request->phone,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $pesan = "ini kode untuk ganti password baru silahkan di masukkan di web kami " . $token;
        $this->send_message($phone,$pesan);
        $request->session()->put('changeToken',$token);

        return redirect()->route('change.token',compact('phone'))->with('message','kami telah mengirim kode ke whatsapp anda silahkan dicek!');
    }

    public function changeToken(Request $request){
        $user = $request->session()->get('changeToken');

        if(!$user){
            return redirect()->route('login');
        }else{
            return view('auth.phone-password.token-confirm',compact('user'));
        }
    }

    public function confirmToken(Request $request){
        $data = $request->token;

        $random_url = Str::random(64);

        $confirm = DB::table('password_token')->where('token',$data)->first();

        if(!$confirm){
            return redirect()->back()->withErrors(['token','kamu salah masukkan token'])->withInput();
        }else{
            return redirect()->route('password.reset',compact('random_url','data'));
        }
        
    }

    public function password_reset(Request $request){
        $data = $request->data;

        return view('auth.phone-password.password-reset',compact('data'));
    }

    public function password_reset_process(Request $request){
        $request->validate([
            'phone' => 'required|min:11|max:13',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_token')->where('phone',$request->phone)->where(  'token',$request->token)->first();

        if(!$updatePassword){
            return back()->withInput()->with('error','invalid token!');
        }
        $user = User::where('phone',$request->phone)->update(['password' => Hash::make($request->password)]);
        // dd($user);

        DB::table('password_token')->where('phone' , $request->phone)->delete();

        return redirect('/login')->with('success','password bersil diubah silahkan login');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
