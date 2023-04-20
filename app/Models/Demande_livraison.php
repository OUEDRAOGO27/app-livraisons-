<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Demande_livraison extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_client',
        'id_type_liv',
        'long_depart',
        'lat_depart',
        'libelle_depart',
        'long_arrive',
        'lat_arrive',
        'libelle_arrive',
        'poids_colis',
        'quantite_colis',
        'taille_colis',
        'tarifs',
        'date_livraison',
        'isActive',
        'isDelete',
    ];
}
