<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Viaje
 *
 * @property $cod_via
 * @property $car_via
 * @property $pes_via
 * @property $est_via
 * @property $fec_sal_via
 * @property $hor_sal_via
 * @property $fec_lle_via
 * @property $hor_lle_via
 * @property $kil_via
 * @property $com_via
 * @property $cam_via
 * @property $cli_via
 * @property $rut_via
 * @property $emp_via
 * @property $created_at
 * @property $updated_at
 *
 * @property Camione $camione
 * @property Cliente $cliente
 * @property Empresa $empresa
 * @property Ruta $ruta
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Viaje extends Model
{

    protected $primaryKey = 'cod_via';
    
    static $rules = [
		'cod_via' => 'required',
		'car_via' => 'required',
		'pes_via' => 'required',
		'est_via' => 'required',
		'fec_sal_via' => 'required',
		'hor_sal_via' => 'required',
		'fec_lle_via' => 'required',
		'hor_lle_via' => 'required',
		'kil_via' => 'required',
		'com_via' => 'required',
		'cam_via' => 'required',
		'cli_via' => 'required',
		'rut_via' => 'required',
		'emp_via' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cod_via','car_via','pes_via','est_via','fec_sal_via','hor_sal_via','fec_lle_via','hor_lle_via','kil_via','com_via','cam_via','cli_via','rut_via','emp_via'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function camione()
    {
        return $this->hasOne('App\Models\Camione', 'pla_cam', 'cam_via');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cliente()
    {
        return $this->hasOne('App\Models\Cliente', 'cod_cli', 'cli_via');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa', 'nit_emp', 'emp_via');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ruta()
    {
        return $this->hasOne('App\Models\Ruta', 'cod_rut', 'rut_via');
    }
    

}
