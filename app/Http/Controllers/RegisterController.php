<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|min:8',
    ]);

    if($validator->fails()){
        return response()->json(['error' => 'Validation Error.', 'details' => $validator->errors()], 422);       
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    
    $user = User::create($input);

    $success['token'] = $user->createToken('MyApp')->plainTextToken;
    $success['name'] = $user->name;

    return response()->json(['success' => $success, 'message' => 'User registered successfully.']);
}

   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
   public function login(Request $request): JsonResponse
{
    $credentials = $request->only('name', 'password');
    
    // Essayer d'abord avec le nom d'utilisateur
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User login successfully.');
    } else {
        // Si la connexion avec le nom échoue, essayer avec le téléphone
        $credentials = ['phone' => $request->name, 'password' => $request->password];
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}

public function loginWithPhone(Request $request): JsonResponse
{
    // Vérifier si l'utilisateur avec le nom et le numéro de téléphone existe
    $user = User::where('phone', $request->phone)->where('name', $request->name)->first();

    if ($user) {
        // Générer un token pour l'utilisateur
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User login successfully.');
    } else {
        return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
    }
}



}