<?php

/**
 * Class Product
 *
 * Represents a product entity in the system.
 *
 * @package   App\Models
 * @author    José González <jose@bitgenio.com>
 * @copyright 2025 Bitgenio DevOps SLU
 * @since     26/03/2025
 * @version   1.0.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'image', 
        'user_id'];


          /**
     * Defines a many-to-one relationship between Product and User.
     */
        public function user(){

            return $this->belongsTo(User::class);
        }
}
