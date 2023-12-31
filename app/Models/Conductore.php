<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conductore
 *
 * @property $dni_con
 * @property $nom_con
 * @property $num_lic_con
 * @property $fec_ven_lic_con
 * @property $fec_con_con
 * @property $est_con
 * @property $fec_nac_con
 * @property $dir_con
 * @property $num_tel_con
 * @property $cor_ele_con
 * @property $año_exp_con
 * @property $eps_con
 * @property $created_at
 * @property $updated_at
 *
 * @property Camione[] $camiones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Conductore extends Model
{

  protected $primaryKey = 'dni_con';
  public $incrementing = false;
  
  static $rules = [
    'dni_con' => 'required|unique:conductores',
		'nom_con' => 'required',
		'num_lic_con' => 'required',
		'fec_ven_lic_con' => 'required',
		'fec_con_con' => 'required',
		'est_con' => 'sometimes',
		'fec_nac_con' => 'required',
		'dir_con' => 'required',
		'num_tel_con' => 'required',
		'cor_ele_con' => 'required',
		'año_exp_con' => 'required',
		'eps_con' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['dni_con','nom_con','num_lic_con','fec_ven_lic_con','fec_con_con','est_con','fec_nac_con','dir_con','num_tel_con','cor_ele_con','año_exp_con','eps_con'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function camiones()
    {
        return $this->hasMany('App\Models\Camione', 'con_cam', 'dni_con');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($conductore) {
            $user = User::where('email', $conductore->cor_ele_con)->first();
            if ($user) {
                $user->delete();
            }
        });
    }

}