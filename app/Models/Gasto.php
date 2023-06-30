<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Gasto
 *
 * @property $cod_gas
 * @property $mon_gas
 * @property $fec_gas
 * @property $cat_gas
 * @property $rut_gas
 * @property $emp_gas
 * @property $created_at
 * @property $updated_at
 *
 * @property CategoriasGasto $categoriasGasto
 * @property Empresa $empresa
 * @property Ruta $ruta
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Gasto extends Model
{
    
    protected $primaryKey = 'cod_gas';
    public $incrementing = false;

    static $rules = [
		'cod_gas' => 'required',
		'mon_gas' => 'required',
		'fec_gas' => 'required',
		'cat_gas' => 'required',
		'rut_gas' => 'required',
		'emp_gas' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cod_gas','mon_gas','fec_gas','cat_gas','rut_gas','emp_gas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categoriasGasto()
    {
        return $this->hasOne('App\Models\CategoriasGasto', 'cod_cat_gas', 'cat_gas');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa', 'nit_emp', 'emp_gas');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ruta()
    {
        return $this->hasOne('App\Models\Ruta', 'cod_rut', 'rut_gas');
    }
    

}
