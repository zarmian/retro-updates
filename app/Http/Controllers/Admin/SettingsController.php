<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Settings;
use App\ThirdParty\SlimStatus;
use Illuminate\Http\Request;
use App\ThirdParty\Slim;
use Carbon\Carbon;
use DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = [];

            $st = Settings::select('config_name', 'config_value', 'serialized')->get();
            if(isset($st) )
            {
                foreach($st as $setting)
                {

                  $data[$setting->config_name] = $setting->config_value;

                  if(isset($setting['serialized']) && $setting['serialized'] == 1){
                    $data[$setting->config_name] = unserialize($setting->config_value);
                  }

                }
               
            }

            $data['countries'] = DB::table('tbl_countries')->get();
            $data['timezones'] = DB::table('tbl_countries_zone')->get();
            $data['days'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

            return view('admin.settings', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            if($request->input('st'))
            {


              foreach($request->input('st') as $key=>$val)
              {

                if(is_array($val)){
                  $values[] = ['config_name' => $key, 'config_value' => serialize($val), 'serialized' => true];
                }else{
                  $values[] = ['config_name' => $key, 'config_value' => $val, 'serialized' => false];
                }
                
              }
             
              $casessr = [];
              foreach ($values as $key=>$value) {
                                   $id = $value['config_name'];
                  $config_value = $value['config_value'];
                  $cases[] = "WHEN '".$id."' then '".$value["config_value"]."'";
                  $params[] = $value['config_value'];
                  $ids[] = "'{$id}'";
                  
                  if(isset($value['serialized']) && $value['serialized'] == true)
                  {
                    $casessr[] = "WHEN '{$id}' then '1'";
                  }else{
                    $casessr[] = "WHEN '{$id}' then '0'";
                  }
                  
              }


             $ids = implode(', ', $ids);
             $cases = implode(' ', $cases);
             $casessr = implode(' ', $casessr);

               
             $update =  DB::update("UPDATE tbl_settings SET `config_value` = CASE `config_name` {$cases} END, `serialized` = CASE `config_name` {$casessr} END
               WHERE `config_name` IN (".$ids.")");

              if(isset($update) && $update == 1)
              {
                  $request->session()->flash('msg', __('admin/common.save_setting_msg'));
              }

              return redirect('/setting');
                
            }
            
            
        } catch (ModelNotFoundException $e) {
            return redirect('/setting');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
      try {

        if($request->logo)
        {
          $images = Slim::getImages('logo');

          $image = $images[0];
          $path = storage_path().'/app/logo/';
          $file = Slim::saveFile($image['output']['data'], $image['input']['name'], $path);


          Settings::where('config_name', 'BUSINESS_LOGO_IMAGE')->update(['config_value' => $file['name']]);

          Slim::outputJSON(SlimStatus::Success);

        }
        
      } catch (ModelNotFoundException $e) {
        
      }
    }

}
