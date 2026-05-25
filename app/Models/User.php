<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'boutique_name',
        'phone',
        'whatsapp',
        'is_active',
        'address',
        'city',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relation : un vendeur a plusieurs produits
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * Récupère l'abonnement actif du vendeur
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            });
    }

    /**
     * Vérifie si le vendeur peut ajouter un nouveau produit
     */
    public function canAddProduct()
    {
        // Admin n'a pas de limite
        if ($this->role === 'admin') {
            return true;
        }
        
        // Vendeur non validé ne peut pas ajouter
        if (!$this->is_active) {
            return false;
        }
        
        // Récupérer l'abonnement actif
        $subscription = $this->activeSubscription;
        
        // Si pas d'abonnement, utiliser le plan gratuit (5 produits max)
        $maxProducts = $subscription ? $subscription->max_products : 5;
        
        // Compter les produits actifs (non supprimés)
        $currentProducts = $this->products()->count();
        
        return $currentProducts < $maxProducts;
    }

    /**
     * Récupère la limite maximale de produits
     */
    public function getMaxProductsAttribute()
    {
        if ($this->role === 'admin') {
            return PHP_INT_MAX;
        }
        
        $subscription = $this->activeSubscription;
        return $subscription ? $subscription->max_products : 5;
    }
     /**
     * Réclamations faites par l'utilisateur (en tant qu'acheteur)
     */
     public function claimsAsBuyer()
    {
     return $this->hasMany(Claim::class, 'buyer_id');
    }

     /**
     * Réclamations reçues par l'utilisateur (en tant que vendeur)
     */
     public function claimsAsSeller()
    {
     return $this->hasMany(Claim::class, 'seller_id');
    }
}