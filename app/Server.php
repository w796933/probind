<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'hostname'     => 'required|string',
        'ip_address'   => 'required|ip',
        'type'         => 'required|in:master,slave',
        'push_updates' => 'required|boolean',
        'ns_record'    => 'required|boolean',
        'directory'    => 'required|string',
        'template'     => 'string',
        'script'       => 'required_if:push_updates,1|string',
        'active'       => 'required|boolean'
    ];
    /**
     * The database table used by the model.
     */
    protected $table = 'servers';
    protected $fillable = [
        'hostname',
        'ip_address',
        'type',
        'push_updates',
        'ns_record',
        'directory',
        'template',
        'script',
        'active'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'hostname'     => 'string',
        'ip_address'   => 'string',
        'type'         => 'string',
        'directory'    => 'string',
        'template'     => 'string',
        'script'       => 'string'
    ];

}