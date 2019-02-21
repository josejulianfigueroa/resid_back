<?php

namespace App;

use App\Reservacion;
use App\Scopes\UserReservacionScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable  implements JWTSubject
{

    use Notifiable, SoftDeletes;
    
    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       // 'cedula', 
        'nombre',
       // 'apellido',
        'email', 
        'password',
        'imagen',
     //   'verified',
     //   'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     * Atributos ocultos es la repsuesta http
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token'
    ];

/*
protected static function boot(){ // Metodo para agregar el scope creado
    parent::boot(); //llamamos al metodo padre 
    static::addGlobalScope(new UserReservacionScope);

}*/





//Mutador y Accesor funcionan automaticos al crear datos
// Mutadores
    public function setNombreAttribute($valor){
        $this->attributes['nombre'] = strtolower($valor);
    }
       public function setEmailAttribute($valor){
        $this->attributes['email'] = strtolower($valor);
    }

    // Accesor
    public function getNombreAttribute($valor){
      // return ucfirst($valor); Cambia la primera letra de la primera palabra del nombre
       // Se retorna una transformacion del atributo, esta no se hace efectiva al valor original
         return ucwords($valor);//Cambia la primera letra de cada palabra
    }


     public function esVerificado(){
        return $this->verified == User::USUARIO_VERIFICADO;
    }
      public function esAdministrador(){
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }


    // Relaciones
    public function tiene_reservacion(){
        return $this->hasMany(Reservacion::class);
     }


    // El metodo es static ya que no requerimos de una instancia para generar dicho token de verificacion
   public static function generarVerificationToken(){
        return str_random(40); // De 24 caracteres en adelante
    }

     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

     public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    
}
