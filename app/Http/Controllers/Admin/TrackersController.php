<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Products;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Models\ConfigParams;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Models\Status;
use App\Http\Models\Assets;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class TrackersController extends Controller
{
    public function __construct()
    {

    }

    public function create_tracker()
    {
        return view('admin.tracker.create_tracker');
    }

   
    public function edit_tracker(Request $request)
    {
        $tracker = User::where('id', $request['info'])->first();
        return view('admin.tracker.edit_tracker', compact('tracker'));
    }

    protected function validator(array $data)
    {
        $validator = array(
            'tracker_id' => 'required',
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('users')->ignore($data['tracker_id'])],
            'phone' => ['required', 'max:255'],
            'role' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($data['tracker_id'])],

        );
        if (isset($data['password']) && !empty($data['password'])) {
            $validator['password'] = ['required', 'min:6', 'confirmed'];
        }


        return Validator::make($data, $validator);
    }

    public function update_trackers(Request $request)
    {

        $validation = $this->validator($request->all());

        if ($validation->fails()) {

            return redirect()->back()->with('error', $validation->errors()->first());
        }

        $data = array('name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => $request['role']);
        if (isset($request['password']) && !empty($request['password'])) {
            $data['password'] = Hash::make($request['password']);
        }


        if (isset($request['file']) && !empty($request['file'])) {

            $user_row = User::where('id', $request['tracker_id'])->first();

            if ($user_row->image) {
                $path = public_path() . '/assets/trackers/' . $user_row->image;
                \File::delete($path);
            }
            $image = $request->file('file');
            $name = date("dmyHis.") . gettimeofday()["usec"] . '_' . 'tracker' . $image->getClientOriginalName();
            $image->move(public_path() . '/assets/trackers/', $name);

            $data['image'] = $name;
        }

        // update track
        $tracking_id = User::where('id', $request['tracker_id'])->update($data);
//
//        // msg
        if ($tracking_id > 0) {
            return redirect()->route('tracker.list')->with('success', Session::get('Tracker_updated'));

        } else {
            return redirect()->back()->with('error', Session::get('Error'));


        }
    }

    public function update_tracker_status(Request $request)
    {
        $status = $request['status'] == 'Y' ? 'N' : 'Y';
        $affectedRows = User::where('id', '=', $request['id'])
            ->update(array('is_active' => $request['status'] == 'Y' ? 'N' : 'Y'));
        if ($affectedRows) {
            $finalResult = array('msg' => 'success', 'response' => Session::get('Tracker_status_updated'));
            echo json_encode($finalResult);
        } else {
            $finalResult = array('msg' => 'failure', 'response' => Session::get('Error'));
            echo json_encode($finalResult);
        }
    }

    public function deleteUser(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = User::findOrFail($id);
        if ($user) {
            $user->is_deleted = 'Y';
            $user->update();
        }

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

}
