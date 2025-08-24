<?php

declare(strict_types=1);

namespace TenantForge\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Database\Factories\PostFactory;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    /**
     * @return PostFactory<Post>
     */
    public static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
