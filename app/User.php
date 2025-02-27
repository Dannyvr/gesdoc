<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that is the primaryKey
     *
     * @var array
     */
    protected $primaryKey = 'username';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username',  'email', 'role_id','department_id', 'password','api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'Cedula_verified_at' => 'datetime',
    ];


    /**
     * The user belongs to a role
    */
    public function role() {
        return $this->belongsTo('App\Role');
    }

    /**
     * The user has many flows
    */
    public function flows() {
        return $this->hasMany('App\Flow');
    }

        /**
     * The user has many flows
    */
    public function classifications() {
        return $this->hasMany('App\Classification');
    }

    /**
     * Relationship many to many
    */
    public function documents() {
        return $this->hasMany('App\Document');
    }

    /**
     * One step belongs to a StepUser
    */
    public function stepUser() {
        return $this->belongsTo('App\StepUser');
    }

    /**
     * One step belongs to a StepUser
    */
    public function getAccionDocuments($documentId) {
        return $this->belongsToMany('App\Action','action_document_user','username','action_id');
    }

}
