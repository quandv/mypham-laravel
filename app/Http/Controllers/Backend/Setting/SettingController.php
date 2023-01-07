<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Artisan;
use Validator;
class SettingController extends Controller
{
    //
    public function getSetting(){
    	return view('backend.setting.setting');
    }
    public function postSetting(Request $request){
    	/*$this->validate($request, [
            'setting_name' => 'required',
        ],[
            'setting_name.required'=> 'Nội dung không được để trống',
        ]);*/
        $rules = [
            'setting_name'  => 'required',
            'per_page'      => 'required|numeric|min:1'
        ];
        $messages = [
            'setting_name.required' => 'Nội dung không được để trống',
            'per_page.min'          => 'Số lượng sản phẩm trên 1 trang phải lớn hơn hoặc bằng 1',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator,'setting')
                        ->withInput();
        }else{
            $data = [ 
                'order_notification' => htmlentities($request->input('setting_name')),
                'realtime'  =>$request->input('optionsRadios'),
                'pstatus'   =>$request->input('optionsPstatus'),
                'per_page'  =>$request->input('per_page'),
            ];      
            $data = var_export($data, 1);
            if(File::put(config_path() . '/vgmconfig.php', "<?php\n return $data ;")) {
                // Successful, return Redirect...
                Artisan::call('config:cache');
                return redirect()->back()->with('flash_message_succ','Cập nhật thành công');
            }
        }
        

    }
    public function postSettingEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email_setting.*' => 'required|email',
        ],[
            'email_setting.*.required'=> 'Email không được để trống',
            'email_setting.*.email'=> 'Định dạng email không đúng',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator,'email')
                        ->withInput();
        }else{
            $data = ['to'=> array_unique($request->email_setting)];      
            $data = var_export($data, 1);
            if(File::put(config_path() . '/vgmmail.php', "<?php\n return $data ;")) {
                // Successful, return Redirect...
                Artisan::call('config:cache');
                return redirect()->back()->with('flash_message_succ','Cập nhật thành công');
            }
        }

    }
}
