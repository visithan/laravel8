<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function addNewUser(Request $request)
    {
    }

    public function editUser(Request $request)
    {
    }

    public function getAllUsers()
    {
        //$users = User::all();
        //$users = User::paginate(5);
        //$users = DB::select('select * from users where active = ?', [1]);
        //$users = DB::select('SELECT * FROM users');
        $users = User::latest()->paginate(5);
        return view('user.usercontrol', ['users' => $users]);
    }

    public function getAllUsersDataTable(Request $request)
    {
        $postData = $request->post();
        if (empty($postData['draw'])) {
            return abort(404, 'Page not found');
        }
        $columns = array(
            // datatable column index  => database column name
            0 => 'id',
            1 => 'name',
            2 => 'user_name',
            3 => 'email',
            4 => 'active_status',
            5 => 'created_at',
            6 => 'updated_at',
        );

        //$totalData = User::count();              //Count using User Object
        $totalData = DB::table('users')->count(); //Count using Query builder
        $totalFiltered = $totalData; // when there is no search parameter then total number rows = total number filtered rows.

        $query = DB::table('users')->select('id', 'name', 'user_name', 'email', 'active_status', 'created_at', 'updated_at');
        //$query->where(null);

        if (!empty($postData['columns'][1]['search']['value'])) {
            $query->Where('name', 'LIKE', '%' . $postData['columns'][1]['search']['value'] . '%');
        }

        if (!empty($postData['columns'][2]['search']['value'])) {
            $query->Where('user_name', 'LIKE', '%' . $postData['columns'][2]['search']['value'] . '%');
        }

        if (!empty($postData['columns'][3]['search']['value'])) {
            $query->Where('email', 'LIKE', '%' . $postData['columns'][3]['search']['value'] . '%');
        }

        if (!empty($postData['columns'][4]['search']['value'])) {
            $query->Where('active_status', '=', $postData['columns'][4]['search']['value']);
        }

        if (!empty($postData['search']['value'])) { // if there is a search parameter, $postData['search']['value'] contains search parameter
            $query->Where($columns[0], 'LIKE', '%' . $postData['search']['value'] . '%')
                ->orWhere($columns[1], 'LIKE', '%' . $postData['search']['value'] . '%')
                ->orWhere($columns[2], 'LIKE', '%' . $postData['search']['value'] . '%')
                ->orWhere($columns[3], 'LIKE', '%' . $postData['search']['value'] . '%');
        }
        $totalFiltered = $query->count();

        if (isset($postData['order'])) {
            $query->orderBy($columns[$postData['order'][0]['column']], $postData['order'][0]['dir']);
        }

        if (isset($postData['length'])) {
            $query->offset($postData['start'])
                ->limit($postData['length']);
        }
        $results = $query->get();
        //$results1 = json_decode(json_encode($results), true);

        $data = array();
        foreach ($results as $row) {
            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->name;
            $sub_array[] = $row->user_name;
            $sub_array[] = $row->email;
            $sub_array[] = $row->active_status;
            $sub_array[] = $row->created_at;
            $sub_array[] = $row->updated_at;
            $sub_array[] = $this->getActionBtns($row);
            $data[] = $sub_array;
        }
        $json_data = array(
            "draw" => $postData['draw'], // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => $totalData, // total number of records
            "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data, //$results   // total data array
            "sql" => $query->toSql(), //$results//
        );
        return response()->json($json_data);
        //return view('user.test', ['users' => $query->toSql()]);
    }

    private function getActionBtns($row)
    {
        $var = ($row->active_status == 1) ? '<i class="fas fa-lock-open"></i>' : '<i class="fas fa-lock"></i>';
        return
            '<div class="btn-group">
            <button type="button" id="' . $row->id . '" class="btn btn-warning edituser" title="Edit">
            <i class="fas fa-user-edit"></i></button>
            <button type="button" id="' . $row->id . '" class="btn btn-info passwordreset" title="Password Reset"
            data-toggle="tooltip"><i class="fas fa-key"></i></button>
            <button type="button" id="' . $row->id . '" class="btn btn-primary changeactivestatus"
            title="Activate/Deactivate User">' . $var . '</button>
            <button type="button" id="' . $row->id . '" class="btn btn-danger deleteuser" title="Delete"
            data-toggle="tooltip"><i class="fas fa-trash-alt"></i></button>
            </div>';
    }

    public function getUser(Request $request)
    {
        // Retrieve a model by its primary key...
        if ($request->ajax() && $request->isMethod('post')) {
            $postData = $request->post();
            try {
                $user = User::find($postData['id']);
                return response()->json($user, 200);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json($ex->getMessage(), 200);
            }
        } else {
            return abort(404, 'Page not found');
        }
    }

    public function updateUser(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $postData = $request->post();
            try {
                $User = User::where('id', $postData['uid'])
                    ->update([
                        'name' => $postData['fname'],
                        'user_name' => $postData['uname'],
                        'email' => $postData['email'],
                    ]);
                $json_data = array(
                    'type' => 'success',
                    'msg' => 'The user with user_Id ' . $postData['uid'] . ' has been successfully updated.',
                );
                return response()->json($json_data);
            } catch (\Illuminate\Database\QueryException $e) {
                $json_data = array(
                    'type' => 'error',
                    'msg' => $e->getMessage(),
                );
                return response()->json($json_data);
            }
        } else {
            return abort(404, 'Page not found');
        }
    }

    public function adnewUser(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $user = new User();
                $user->name = $request->input('nufname') . " " . $request->input('nulname');
                $user->user_name = $request->input('nuuname');
                $user->email =  $request->input('nuemail');
                $user->password = Hash::make($request->input('nupass1'));
                $user->active_status = 0;
                $user->save();
                return response()->json([
                    'type' => 'success',
                    'msg' => 'The user "' . $request->input('nufname') . ' ' . $request->input('nulname') . '" has been successfully created.',
                ]);
            } catch (\Exception $ex) {
                $json_data = array(
                    'type' => 'error',
                    'msg' => $ex->getMessage(),
                );
            }
        }
    }

    public function changeUserStatus(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $postData = $request->post();
            try {
                $user = User::find($postData['uid']);
                if ($user->active_status == 1) {
                    $User = User::where('id', $postData['uid'])
                        ->update([
                            'active_status' => 0,
                        ]);
                } else {
                    $User = User::where('id', $postData['uid'])
                        ->update([
                            'active_status' => 1,
                        ]);
                }
                $json_data = array(
                    'type' => 'success',
                    'msg' => 'The status of the user with user_Id ' . $postData['uid'] . ' has been successfully updated.',
                );
                return response()->json($json_data);
            } catch (\Illuminate\Database\QueryException $e) {
                $json_data = array(
                    'type' => 'error',
                    'msg' => $e->getMessage(),
                );
                return response()->json($json_data);
            }
        } else {
            return abort(404, 'Page not found');
        }
    }

    public function deleteUser(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $postData = $request->post();
            try {
                $res = User::destroy($postData['uid']);
                if ($res) {
                    $json_data = array(
                        'type' => 'success',
                        'msg' => 'The user with user_Id ' . $postData['uid'] . ' has been successfully deleted.',
                    );
                } else {
                    $json_data = array(
                        'type' => 'error',
                        'msg' => 'The user with user_Id ' . $postData['uid'] . ' has not been deleted.',
                    );
                }
                return response()->json($json_data);
            } catch (\Illuminate\Database\QueryException $e) {
                $json_data = array(
                    'type' => 'error',
                    'msg' => $e->getMessage(),
                );
                return response()->json($json_data);
            }
        } else {
            return abort(404, 'Page not found');
        }
    }

    public function deleteUsers(Request $request)
    {
    }

    public function userPasswordReset(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $postData = $request->post();
            try {
                $password = Hash::make($request->input('pwrspass1'));
                $User = User::where('id', $postData['pwrsuid'])
                    ->update([
                        'password' => $password,
                    ]);
                $json_data = array(
                    'type' => 'success',
                    'msg' => 'Password of the user with user_Id ' . $postData['pwrsuid'] . ' has been successfully changed.',
                );
                return response()->json($json_data);
            } catch (\Illuminate\Database\QueryException $e) {
                $json_data = array(
                    'type' => 'error',
                    'msg' => $e->getMessage(),
                );
                return response()->json($json_data);
            }
        } else {
            return abort(404, 'Page not found');
        }
    }


    protected function getNewUserValidator(Request $request)
    {
        $input = $request->all();
        $rules = [
            'email' => 'bail|required|email|unique:users,email',
            'uname' => 'bail|required|min:4|max:10|unique:users,user_name',
            'pass1' => 'bail|required|min:4|max:10',
            'pass2' => 'bail|required|min:4|max:10|same:pass1',
        ];
        $messages = [
            'email.required' => 'Please provide your Email address for better communication',
            'email.unique' => 'Sorry, This Email address is already used by another user. please try with different one.',
            'uname.required' => 'Please choose Your User Name',
            'uname.unique' => 'Sorry, This user name is already used by another user. Please try with different one.',
            'pass1.required' => 'Password is required for your information safety',
            'pass1.min' => 'Password length should be more than 4 character',
            'pass2.required' => 'Please Re-enter your password',
            'pass2.same' => 'Passwords are not matched',
        ];
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }


    private function successMsg($msg)
    {
        return ('<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success! </strong> ' . $msg . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
    }

    private function failedMsg($msg)
    {
        return ('<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Failed! </strong> ' . $msg . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
    }
}
