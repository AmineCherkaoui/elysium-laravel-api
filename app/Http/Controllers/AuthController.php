<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Traits\ApiResponses;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{


    use ApiResponses;
   public function register(RegisterUserRequest $request)
    {
    $credentials = $request->validated();

    $user = User::create([
        'name' => $credentials['name'],
        'email' => $credentials['email'],
        'password' => Hash::make($credentials['password']),
    ]);

    $token = $user->createToken('api-token-'. $user->email,["*"],now()->addHour())->plainTextToken;

    return $this->success('Utilisateur créé avec succès.', [
        'user' => $user->only(['id', 'name', 'email']),
        'token' => $token
    ]);
    }

    use ApiResponses;
    public function login(LoginUserRequest $request)
    {

            $credentials = $request->validated();

            if(!Auth::attempt($credentials)) {
                return $this->error("Identifiants invalides",401);
            }

           $user = Auth::user();
           $user->tokens()->delete();

            $token = $user->createToken('api-token-'. $user->email,["*"],now()->addHour())->plainTextToken;

            return $this->success("Authentification réussie",[
                "user"=> $user->only(["id","name","email"]),
                "token"=> $token,
            ]);


    }
    use ApiResponses;
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success("Déconnexion réussie");
    }

    use ApiResponses;
      public function user(Request $request)
    {

       $user = $request->user();

        if (!$user) {
            return $this->error('Utilisateur non authentifié.', 401);
        }

        return $this->success('Utilisateur authentifié avec succès.', [
            'user' => $user->only(['id', 'name', 'email']),
        ]);
    }

use ApiResponses;
    public function updateUser(UpdateUserRequest $request){
    $user = $request->user();
     if (!$user) {
            return $this->error('Utilisateur non authentifié.', 401);
        }

        $data = $request->validated();

        if((isset($data['password']))){
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

    return $this->success("Informations mises à jour avec succès.", [
            'user' => $user->only(['id', 'name', 'email']),
        ]);

    }



}


