<?php


namespace App\Http\Controllers\Api;

use App\Http\Models\Company;
use App\Http\Models\Products;
use Auth;
use App\Http\Models\Tracking;
use App\Http\Models\Tracking_image;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Models\UserDevice;
use Illuminate\Support\Facades\File;
use App\Http\Models\Client_company;
use App\Http\Models\Status;
use App\Http\Models\Cities;
use App\Http\Models\Assets;
use Illuminate\Validation\Rule;
class ApiController extends ResponseController
{
    public function alltrackings(Request $request)
    {
//        $trackings = Tracking::where('created_by', request()->user()->id)->orderBy('id','desc')->get();

        $trackings = DB::table('mod_3_tracking')
            ->leftJoin('users', 'mod_3_tracking.created_by', 'users.id')
            ->select('mod_3_tracking.*', 'users.name','users.image')
            ->where('mod_3_tracking.created_by', request()->user()->id)->orderBy('mod_3_tracking.id','desc')->get();

        $trackings = $trackings->map(function ($ticket) {

            return $this->get_track_detail($ticket);
        });

        if(count($trackings) > 0){
            return $this->sendResponse(1, 'Showing all trackings',$trackings);
        }

        return $this->sendResponse(1, 'Tracking not found',$trackings);
    }

    public function get_track_detail($ticket){
        $ticket->status_name = Status::find($ticket->status_id)->title;
        $ticket->company_name = Client_company::find($ticket->company_id)->company_name;
        $ticket->city_name = Cities::where('city_id',$ticket->city_id)->first()->city_name;
        $ticket->created_by_name =  $ticket->name;
        $ticket->updated_by_name= User::find($ticket->updated_by)->name;
        $ticket->user_image = ($ticket->image ?    getImageUrl($ticket->image,'tracker') :   getImageUrl('images.png','tracker') );
        $assets = Assets::where('id',$ticket->asset_id)->first();
        if($assets) {
            // assets detail
            $ticket->asset_region = $assets->region;
            $ticket->asset_city_id = $assets->city;
            $ticket->asset_city_name = Cities::where('city_id', $assets->city)->first()->city_name;
            $ticket->asset_address = $assets->address;
            $ticket->asset_type = $assets->asset_type;
            $ticket->asset_name = $assets->asset_type;
        }
        $ticket->attachments = Tracking_image::where('tracking_id',$ticket->id)->get();
        $ticket->attachments  = $ticket->attachments->map(function ($ticket) {

            $ticket['file'] =  getImageUrl($ticket->file,'tracking');
            return $ticket;
        });

        return $ticket;
    }

    public function trackDetails(Request $request){

        $validator = Validator::make($request->all(), [
            'tracking_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError(0, "Required fields are missing", $validator->errors()->all());
        }
        $tracking_id = $request->get('tracking_id');
        $userID = $request->user()->id;

        $tracking = DB::table('mod_3_tracking')
            ->leftJoin('users', 'mod_3_tracking.created_by', 'users.id')
            ->select('mod_3_tracking.*', 'users.name','users.image')
            ->where('mod_3_tracking.id', $tracking_id)->orderBy('mod_3_tracking.id','desc')->get();
//        $tracking = Tracking::where('id', $tracking_id)->get();

        if(count($tracking) == 0){
            return $this->sendError(0, 'Data not found.');
        }
        $tracking = $tracking->map(function ($data) {

            return $this->get_track_detail($data);
        });


        if($tracking){
            return $this->sendResponse(1, 'Showing track details', $tracking);
        }else{
            return $this->sendError(0, 'Something went wrong! Please try again"', $tracking);
        }

    }

    public function updatetracking(Request $request) {

        // validation
        $validator = Validator::make($request->all(), [
            'tracking_id' => 'required',
            'company_id' => 'required',
            'night_view' => 'required',
            'light_working' => 'required',
            'status_id' => 'required',
            'city_id' => 'required',
//            'attachment' => 'required',
            'asset_id' => 'required',

        ]);


        if ($validator->fails()) {
            return $this->sendResponse(0, 'Error! Some fields are empty!','error');
        }

        $data=array(
            'company_id' => $request['company_id'],
            'night_view' => $request['night_view'],
            'light_working' => $request['light_working'],
            'status_id' => $request['status_id'] ,
            'asset_id' => $request['asset_id'],
            'updated_by' =>request()->user()->id,
            'city_id' => $request['city_id']
        );
        if(isset($request['comments']) & !empty($request['comments'])){
            $data['comments']=$request['comments'];
        }
        // update track
        $tracking_id=Tracking::where('id', $request['tracking_id'])->update($data);


        // get track detial
        $tracking = Tracking::where('id', $request['tracking_id'])->get();
        $tracking = $tracking->map(function ($data) {
            return $this->get_track_detail($data);
        });


        // msg
        if($tracking_id > 0){
            return $this->sendResponse(1, 'Record updated successfully!',$tracking);
        } else{
            return $this->sendResponse(0, 'Error! Record not created successfully!','error');

        }
//        if($request->hasfile('attachment'))
//        {
//
//            foreach($request->file('attachment') as $file)
//            {
////                return $this->sendResponse(1, 'Record created successfully!',$file);
//                $name = date("dmyHis.").gettimeofday()["usec"].'_'.'tracking';
//                $file->move(public_path().'/tracking_files/', $name);
//                $attachments[] = $name;
//                Tracking_image::create([
//                    'tracking_id' => $tracking_id,
//                    'file' => $name,
//                    'created_by' =>request()->user()->id,
//                    'updated_by' => request()->user()->id
//                ]);
//
//            }
//        }

    }


    public function update_tracker(Request $request){

        // validation
        $validator=array(
            'tracker_id' => 'required',
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('users')->ignore($request['tracker_id'])],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request['tracker_id'])],

        );
        if(isset($request['password']) && !empty($request['password'])){
            $validator['password'] =     ['required', 'min:6', 'confirmed'];
        }
        $validation=  Validator::make($request->all(),$validator);
        if($validation->fails()) {

            return $this->sendResponse(0, 'Error! Some fields are empty!','error');
        }

        $data= array('name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => 2);
        if(isset($request['password']) && !empty($request['password'])){
            $data['password'] = Hash::make($request['password']);
        }


        if(isset($request['file']) && !empty($request['file'])){

            $user_row = User::where('id', $request['tracker_id'])->first();

            if( $user_row->image) {
                $path=public_path() . '/assets/trackers/' . $user_row->image;
                \File::delete($path);
            }
            $image = $request->file('file');
            $name = date("dmyHis.").gettimeofday()["usec"].'_'.'tracker'.$image->getClientOriginalName();
            $image->move(public_path().'/assets/trackers/', $name);

            $data['image']= $name;
        }

        // update track
        $tracking_id=User::where('id', $request['tracker_id'])->update($data);

        // get track detial
        $tracker = User::where('id', $request['tracker_id'])->first();
        $tracker->user_image = ($tracker->image ?    getImageUrl($tracker->image,'tracker') :   getImageUrl('images.png','tracker') );
        $tracker->assets_count=Tracking::where('user_id', $tracker->id)->count();
        if($tracking_id > 0){
            return $this->sendResponse(1, 'Record updated successfully!',$tracker);
        } else{
            return $this->sendResponse(0, 'Error! Record not created successfully!','error');

        }
    }

    public function update_tracker_profile_image(Request $request){

        // validation
        $validator=array(
            'tracker_id' => 'required',
            'file' => 'required'

        );
        if(isset($request['password']) && !empty($request['password'])){
            $validator['password'] =     ['required', 'min:6', 'confirmed'];
        }
        $validation=  Validator::make($request->all(),$validator);
        if($validation->fails()) {

            return $this->sendResponse(0, 'Error! Some fields are empty!','error');
        }

        $data= array( );



        if(isset($request['file']) && !empty($request['file'])){

            $user_row = User::where('id', $request['tracker_id'])->first();

            if( $user_row->image) {
                $path=public_path() . '/assets/trackers/' . $user_row->image;
                \File::delete($path);
            }
            $image = $request->file('file');
            $name = date("dmyHis.").gettimeofday()["usec"].'_'.'tracker'.$image->getClientOriginalName();
            $image->move(public_path().'/assets/trackers/', $name);

            $data['image']= $name;
        }

        // update track
        $tracking_id=User::where('id', $request['tracker_id'])->update($data);

        // get track detial
        $tracker = User::where('id', $request['tracker_id'])->first();
        $trackers = new \stdClass();
        $trackers->user_image = ($tracker->image ?    getImageUrl($tracker->image,'tracker') :   getImageUrl('images.png','tracker') );
        if($tracking_id > 0){
            return $this->sendResponse(1, 'Record updated successfully!',$trackers);
        } else{
            return $this->sendResponse(0, 'Error! Record not created successfully!','error');

        }
    }


    public function get_cities(){
        $Cities = Cities::where('country_id', '=', '166')->get();
        $clients = Client_company::where('is_active', '=', 'Y')->get();
        $status = Status::select('id','title')->where('is_active', '=', 'Y')->get();
        $data=array('status'=>$status ,
            'cities' =>$Cities,
            'clients' =>$clients
        );
        return $this->sendResponse(1, 'result',$data);
    }

    public function get_status(){
        $status = Status::select('id','title')->where('is_active', '=', 'Y')->get();
        return $this->sendResponse(1, 'Status!',$status);
    }

    public function get_assets(Request $request){
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'city' => 'required',

        ]);


        if ($validator->fails()) {
            return $this->sendResponse(0, 'Error! Some fields are empty!','error');
        }

        // update track
        $detail=DB::table('mod_2_company_assets')
            ->leftJoin('com_cities', 'mod_2_company_assets.city', 'com_cities.city_id')
            ->select('mod_2_company_assets.*', 'com_cities.city_name')
            ->where('mod_2_company_assets.company_id', $request['company_id'])
            ->where('mod_2_company_assets.city', $request['city'])
            ->get();
//        $detail=Assets::where('company_id', $request['company_id'])
//            ->where('city',$request['city'])->get();

        if($detail) {
            return $this->sendResponse(1, 'Assets!', $detail);
        }else{
            return $this->sendResponse(1, 'Assets!', []);
        }
    }

    public function storetracking(Request $request) {

        // validation
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'night_view' => 'required',
            'light_working' => 'required',
            'status_id' => 'required',
            'attachment' => 'required',
            'asset_id' => 'required',
            'city_id' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendResponse(0, 'Error! Some fields are empty!');
        }

        $tracking = new Tracking();

        $tracking->company_id = $request['company_id'];
        $tracking->night_view = $request['night_view'];
        $tracking->light_working = $request['light_working'];
        $tracking->status_id = $request['status_id'] ;
        $tracking->asset_id = $request['asset_id'];
        $tracking->city_id = $request['city_id'];
        $tracking->tracking_date = date('Y-m-d H:i:s');
        $tracking->user_id = request()->user()->id;
        $tracking->created_by = request()->user()->id;
        $tracking->updated_by = request()->user()->id;

        if(isset($request['comments']) && !empty($request['comments'])){
            $tracking->comments= $request['comments'];
        }
        $tracking->save();
        $tracking_id=$tracking->id;
        if($request->hasfile('attachment'))
        {

            foreach($request->file('attachment') as $file)
            {
                $name = date("dmyHis.").gettimeofday()["usec"].'_'.'tracking_'.$file->getClientOriginalName();
                $file_type='image';
                $extension = $file->getClientOriginalExtension();
                if($extension === 'mp3' || $extension === 'mp4' || $extension === 'mov' || $extension === 'MOV' || $extension === 'mkv'){
                    $file_type='video';
                }

                $file->move(public_path().'/assets/tracking_files/', $name);
                $attachments[] = $name;
                Tracking_image::create([
                    'tracking_id' => $tracking_id,
                    'file' => $name,
                    'file_type' => $file_type,
                    'created_by' =>request()->user()->id,
                    'updated_by' => request()->user()->id
                ]);

            }
        }

        if($tracking_id > 0){
            return $this->sendResponse(1, 'Record created successfully!',$tracking_id);
        } else{
            return $this->sendResponse(0, 'Error! Record not created successfully!','');

        }
    }
    public function company(Request $request)
    {
        if(Company::where('admin_id',$request->user()->id)->exists())
        {
            $companies = Company::where('admin_id',$request->user()->id)->get();
            return $this->sendResponse(1, 'success',$companies);
        }
        else
        {
            return $this->sendResponse(0, 'Error! Record not created successfully!','');
        }
    }
    public function products(Request $request)
    {
          return 'heheh';
        $product = Products::with([
            'sub_category' => function ($q1) {
                return $q1->with('sub_category');
            }
            , 'category' => function ($q2) {
                return $q2->with('category');
            }
            ])->whereIn('user_id', $request->user()->id)->get();
//        return $product;
    }
}
